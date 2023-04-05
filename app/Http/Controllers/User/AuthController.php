<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Country;
use App\Models\Referral;
use App\Models\LoginLogs;
use App\Helpers\MailHelper;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Generalsetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\AuthRequest;
use App\Http\Resources\User\UserResource;

class AuthController extends Controller
{
  
    public function __construct(UserResource $resource)
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
        $this->resource = $resource;
    }

    public function registerForm()
    {
      $gs = Generalsetting::first();
      if($gs->registration == 0){
        return back()->with('error','Registration is currently off.');
      }

      $refferal = Referral::first();
      if(request('referral') && $refferal->status == 1){
        if(!User::where('username',request('referral'))->exists()){
          return redirect(route('user.register'))->with('error', 'Reference user not found!');
        }
        session()->put('referral', request('referral'));

      }

      $countries = Country::get();
      $info = @loginIp();
      return view('user.auth.register',compact('countries','info'));
    }

    public function register(Request $request)
    {
      $gs = Generalsetting::first();
      if($gs->registration == 0){
        return back()->with('error','Registration is currently off.');
      }

      $countries = Country::query();
      $name = $countries->pluck('name')->toArray();
      $data = $request->validate([
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => ['required','email','unique:users',$gs->allowed_email != null ? 'email_domain:'.$request->email:''],
        'dial_code' => 'required',
        'phone' => 'required',
        'country' => 'required|in:'.implode(',',$name),
        'address' => 'required',
        'password' => 'required|min:6|confirmed',
        'g-recaptcha-response' => [$gs->recaptcha ? 'required':'']
      ],['email.email_domain'=>'Allowed emails are only within : '.$gs->allowed_email]);

      $refferal = Referral::first();
      $referrer = User::where('username',session('referral'))->first();

      $data['referred_by'] = ($referrer && $refferal->status == 1) ? $referrer->id : null;
      $data['phone'] = $request->dial_code.$request->phone;
      $data['password'] = bcrypt($request->password);
      $data['email_verified	'] = $gs->is_verify == 1 ? 0:1;
      $user = User::create($data);

      $this->referralOperation($referrer,$refferal,$user);
      
      session()->flush('success','Registration successful');
      Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);

      if($gs->is_verify == 1){
        $user->verify_code = randNum();
        $user->save();

        @email([
          'email'   => $user->email,
          'name'    => $user->name,
          'subject' => __('Email Verification Code'),
          'message' => __('Email Verification Code is : '). $user->verify_code,
         ]);
      }

      return redirect(route('user.dashboard'));
    }

    public function referralOperation($referrer,$refferal,$user)
    {
      if($referrer && $refferal->status) {
        if($refferal->type == 'register'){ 
            $referrer->balance += $refferal->bonus_amount;
            $referrer->update();

            $trnx              = new Transaction();
            $trnx->trnx        = str_rand();
            $trnx->user_id     = $referrer->id;
            $trnx->bonus_from  = $user->id;
            $trnx->amount      = $refferal->bonus_amount;
            $trnx->charge      = 0;
            $trnx->remark      = 'register_referral_bonus';
            $trnx->type        = '+';
            $trnx->details     = __('Referral bonus from user registeration');
            $trnx->save();

          if($refferal->get_bonus == 'both') {
            $user->balance += $refferal->bonus_amount;
            $user->update();

            $trnx              = new Transaction();
            $trnx->trnx        = str_rand();
            $trnx->user_id     = $user->id;
            $trnx->bonus_from  = $referrer->id;
            $trnx->amount      = $refferal->bonus_amount;
            $trnx->charge      = 0;
            $trnx->remark      = 'register_referral_bonus';
            $trnx->type        = '+';
            $trnx->details     = __('Referral bonus from user registeration');
            $trnx->save();
          }
        } 
        session()->forget('referral');
      }
      return true;
    }

    public function showLoginForm()
    {
      if(Auth::guard('web')->check()){
        return redirect(route('user.dashboard'));
      }
      return view('user.auth.login');
    }

    public function login(Request $request)
    {
      $gs = Generalsetting::first();
      $username = filter_var($request->user, FILTER_VALIDATE_EMAIL);
      $request->validate([
        'user'  => ['required', $username != false ? 'email':''],
        'password'  => 'required',
        'g-recaptcha-response' => [$gs->recaptcha ? 'required':'']
      ],
      [
        'user.required' => 'Email or Username required',
        'user.email' => 'Email must be a valid email address',
        'g-recaptcha-response.required' => 'Please verify that you are not a robot',
      ]);
      
      if($username) $key = 'email';
      else $key = 'username';
      
      if (Auth::attempt([$key => $request->user, 'password' => $request->password])) {
        LoginLogs::create([
            'user_id' => auth()->id(),
            'ip' => @loginIp()->geoplugin_request,
            'country' => @loginIp()->geoplugin_countryName,
            'city' => @loginIp()->geoplugin_city,
        ]);
        return redirect(route('user.dashboard'));
        
      }else{
        return back()->with('error','Wrong credentials');
      }

    }

    public function logout()
    {
        $auth = Auth::guard('web');
        if($auth->user()->two_fa_status == 1){
          $auth->user()->two_fa = 1;
          $auth->user()->save();
        }
        Auth::guard('web')->logout();
        return redirect('/user/login');
    }

    public function forgotPassword()
    {
      return view('user.auth.forgot_password');
    }

    public function forgotPasswordSubmit(Request $request)
    {
        $request->validate(['email'=>'required|email']);
        $exist = User::where('email',$request->email)->first();
        if(!$exist){
          return back()->with('error','Sorry! Email doesn\'t exist');
        }

        $exist->verify_code = randNum();
        $exist->save();

        @email([
          'email'   => $exist->email,
          'name'    => $exist->name,
          'subject' => __('Password Reset Code'),
          'message' => __('Password reset code is : ').$exist->verify_code,
        ]);
        session()->put('email',$exist->email);
        return redirect(route('user.verify.code'))->with('success','A password reset code has been sent to your email.');
    }

    public function verifyCode()
    {
      return view('user.auth.verify_code');
    }

    public function verifyCodeSubmit(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $user = User::where('email',session('email'))->first();
        if(!$user){
            return back()->with('error','User doesn\'t exist');
        }

        if($user->verify_code != $request->code){
            return back()->with('error','Invalid verification code.');
        }
        return redirect(route('user.reset.password'));
    }

    public function resetPassword()
    {
        return view('user.auth.reset_password');
    }

    public function resetPasswordSubmit(Request $request)
    {
        $request->validate(['password'=>'required|confirmed|min:6']);
        $user = User::where('email',session('email'))->first();
        $user->password = bcrypt($request->password);
        $user->update();
        return redirect(route('user.auth.login'))->with('success','Password reset successful.');
    }
 

}
