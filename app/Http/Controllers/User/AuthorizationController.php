<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Generalsetting;
use App\Http\Controllers\Controller;

class AuthorizationController extends Controller
{
    public function twoStep()
    {
      return view('user.twostep.otp_code');
    }

    public function twoStepVerify(Request $request)
    {
        $request->validate(['code'=>'required']);
        $user = auth()->user();
        if($request->code != $user->two_fa_code){
            return back()->with('error','Invalid OTP');
        }
        $user->two_fa = 0;
        $user->save();
        return redirect(route('user.dashboard'));
    }

    public function twoStepResendCode()
    {
        $code = randNum();
        $user = auth()->user();
        $user->two_fa_code = $code;
        $user->update();
        sendSMS($user->phone,'Your two step authentication OTP is : '.$code,Generalsetting::value('contact_no'));
        return back()->with('success','OTP code is sent to your phone.');
    }


    //email verify
    public function verifyEmail()
    {
      return view('user.email_verify.verify_code');
    }

    public function verifyEmailSubmit(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $user = auth()->user();
        if(!$user){
          return back()->with('error','User doesn\'t exist');
        }

        if($user->verify_code != $request->code){
          return back()->with('error','Invalid verification code.');
        }

        $user->verify_code = null;
        $user->email_verified = 1;
        $user->save();
        return redirect(route('user.dashboard'));

    }
}
