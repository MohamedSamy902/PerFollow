<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Admin;
use App\Models\Deposit;
use App\Models\Service;
use App\Models\Currency;
use App\Models\Provider;
use App\Models\Referral;
use App\Models\Transaction;
use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\AdminProfileRequest;



class AdminController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:admin');
   }


    // DASHBOARD
    public function index()
    {
        $data['totalUser']       = User::where('email_verified',1)->count();
        $data['totalCurrency']   = Currency::count();
        $data['totalServices']   = Service::count();
        $data['totalOrders']     = Order::count();
        $data['totalRole']       = DB::table('roles')->count();
        $data['totalStaff']      = Admin::where('role','!=','super-admin')->count();
        $data['recentUsers']     = User::latest()->take(7)->get();
        $data['totalDeposit']    = round(Deposit::with('currency')->sum('default_curr_amount'),3);
        $data['totalProvider']   = Provider::count();
        $data['totalProfit']     = round(Transaction::where('charge','>',0)->sum('charge'),3);

        $orders = Order::selectRaw('count(CASE WHEN status = "completed"  THEN status END) AS completed')
            ->selectRaw('count(CASE WHEN status = "processing" THEN status END) AS processing')
            ->selectRaw('count(CASE WHEN status = "pending"    THEN status END) AS pending')
            ->selectRaw('count(CASE WHEN status = "progress"   THEN status END) AS progress')
            ->selectRaw('count(CASE WHEN status = "partial"    THEN status END) AS partial')
            ->selectRaw('count(CASE WHEN status = "canceled"   THEN status END) AS canceled')
            ->selectRaw('count(CASE WHEN status = "refunded"   THEN status END) AS refunded')
            ->get();

        foreach ($orders as $order) {
            $data['order']['completed']  = $order->completed;
            $data['order']['processing'] = $order->processing;
            $data['order']['pending']    = $order->pending;
            $data['order']['progress']   = $order->progress;
            $data['order']['partial']    = $order->partial;
            $data['order']['canceled']   = $order->canceled;
            $data['order']['refunded']   = $order->refunded;
        }

        $deposits = Deposit::selectRaw('count(id) as totalDepositCount')
            ->selectRaw('count(CASE WHEN status = "completed"  THEN status END) AS completed')
            ->selectRaw('count(CASE WHEN status = "pending"    THEN status END) AS pending')
            ->selectRaw('count(CASE WHEN status = "rejected"   THEN status END) AS rejected')
            ->get();

        foreach ($deposits as $depo) {
            $data['deposit']['totalDepositCount']  = $depo->totalDepositCount;
            $data['deposit']['completed']  = $depo->completed;
            $data['deposit']['rejected']   = $depo->rejected;
            $data['deposit']['pending']    = $depo->pending;
        }

        return view('admin.dashboard',$data);
    }

    // PROFILE
    public function profile()
    {
        $data = admin();
        return view('admin.profile',compact('data'));
    }


    // PROFILE
    public function profileupdate(AdminProfileRequest $request)
    {
        $request->validate(['name'=>'required','email'=>'required|email','phone'=>'required','username'=>'required|unique:admins,username,'.admin()->id]);
        $data = admin();
        $input = $request->only('name','photo','phone','email','username');
        
        if($request->hasFile('photo')){
            $status = MediaHelper::ExtensionValidation($request->file('photo'));
            if(!$status){
                return back()->with('error','Image format is invalid');
            }
            
            $input['photo'] = MediaHelper::handleUpdateImage($request->file('photo'),$data->photo,[200,200]);
        }

        $data->update($input);
        return back()->with('success','Profile Updated Successfully');
    }

    // CHANGE PASSWORD
    public function passwordreset()
    {
        return view('admin.change_password');
    }

    public function changepass(AdminProfileRequest $request)
    {
        $request->validate(['old_password'=>'required','password'=>'required|confirmed|min:6']);
        $user = admin();
        if ($request->old_password){
            if (Hash::check($request->old_password, $user->password)){
                $user->password = bcrypt($request->password);
                $user->update();
            }else{
                return back()->with('error','Old Password Mismatch');  
            }
        }
    
        return back()->with('success','Password Changed Successfully');

    }

    public function transactions()
    {
        $remark = request('remark');
        $search = request('search');

        $transactions = Transaction::when($remark,function($q) use($remark){
            return $q->where('remark',$remark);
        })
        ->when($search,function($q) use($search){
            return $q->where('trnx',$search);
        })
        ->with('currency')->latest()->paginate(15);
        return view('admin.transactions',compact('transactions','search'));
    }

    public function cookie()
    {
        return view('admin.cookie');
    }

    public function updateCookie(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'button_text' => 'required',
            'cookie_text' => 'required'
        ]);

        $gs = Generalsetting::first();
        $gs->cookie = $data;
        $gs->update();
        return back()->with('success','Cookie concent updated');
    }

    public function referralUpdate(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'type'   => 'required',
            'bonus_amount' => 'required|numeric|gt:0',
            'bonus_count' => 'required_if:type,deposit|numeric|gt:0',
            'get_bonus'   => 'required_if:type,register',
        ]);

        $ref = Referral::first();
        $ref->status       = $request->status;
        $ref->type         = $request->type;
        $ref->bonus_amount = $request->bonus_amount;
        $ref->bonus_count  = $request->bonus_count ?? null;
        $ref->get_bonus    = $request->get_bonus ?? null;
        $ref->update();

        return back()->with('success','Referral settings updated');
    }

    public function manageTransfer()
    {
        return view('admin.manage_transfer');
    }

    public function manageTransferUpdate(Request $request)
    {
        $request->validate([
            'trans_status'        => 'required',
            'transfer_fix_charge' => 'required|gt:0|numeric',
            'transfer_percent_charge' => 'required|gt:0|max:100|numeric',
            'min_trans'    => 'required|gt:0|numeric',
            'max_trans'    => 'required|gt:min_trans|numeric'
        ]);

        $gs = GeneralSetting::first();
        $gs->trans_status            = $request->trans_status;
        $gs->transfer_fix_charge     = $request->transfer_fix_charge;
        $gs->transfer_percent_charge = $request->transfer_percent_charge;
        $gs->min_trans               = $request->min_trans;
        $gs->max_trans               = $request->max_trans;
        $gs->save();

        return back()->with('success','Balance Transfer Setting Updated');
        
    }

    public function referral()
    {
        $referral = Referral::first();
        return view('admin.referral',compact('referral'));
    }

    function apiActions()
    {
        $actions = ['add','orders','services','balance','status'];
        return view('admin.api_actions',compact('actions'));
    }

    function updateApiActions()
    {
        $gs = Generalsetting::first();
        $actions = $gs->api_actions;
        $status  = $actions[request('action')];
        $status  = $status == 1 ?  0 : 1;
        $actions[request('action')] = $status;
        $gs->api_actions = $actions;
        $gs->update();

        return response()->json(['success'=>'Action status updated successfully']);
    }

    public function cronjob()
    {
        return view('admin.cronjob');
    }

    public function cronjobStatus()
    {
        $gs = Generalsetting::first();
        if($gs->cron_auto_status == 1) $gs->cron_auto_status = 0;
        else $gs->cron_auto_status = 1;
        $gs->update();
        return response()->json(['success'=>'Data updated successfully']);
    }


    public function activation()
    {
        $activation_data = "";
        if (file_exists(base_path('..').'/project/vendor/markury/license.txt')){
            $license = file_get_contents(base_path('..').'/project/vendor/markury/license.txt');
            if ($license != ""){
                $activation_data = "<i style='color:#08bd08; font-size:45px!important' class='fas fa-check-circle mb-3'></i><br><h3 style='color:#08bd08;'>Your system is activated!</h3>";
            }
        }
        return view('admin.activation',compact('activation_data'));
    }


    public function activation_submit(Request $request)
    {
        
        $purchase_code =  $request->pcode;
        $my_script =  'SMM King';
        $my_domain = url('/');

        $varUrl = str_replace (' ', '%20', config('services.genius.ocean').'purchase112662activate.php?code='.$purchase_code.'&domain='.$my_domain.'&script='.$my_script);

        if( ini_get('allow_url_fopen') ) {
            $contents = file_get_contents($varUrl);
        }else{
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $varUrl);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
        }

        $chk = json_decode($contents,true);

        if($chk['status'] != "success")
        {
            $msg = $chk['message'];
            return back()->with('error',$msg);

        }else{
            $this->setUp($chk['p2'],$chk['lData']);

            if (file_exists(base_path('..').'/rooted.txt')){
                unlink(base_path('..').'/rooted.txt');
            }

            $fpbt = fopen(base_path('..').'/project/vendor/markury/license.txt', 'w');
            fwrite($fpbt, $purchase_code);
            fclose($fpbt);

            $msg = 'Congratulation!! Your System is successfully Activated.';
            return back()->with('success',$msg);
          
        }
       
    }

    function setUp($mtFile,$goFileData){
        $fpa = fopen(base_path('..').$mtFile, 'w');
        fwrite($fpa, $goFileData);
        fclose($fpa);
    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
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
