<?php

namespace App\Http\Resources\User;

use App\Models\Generalsetting;
use App\Models\LoginLogs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserResource {

    public function __construct()
    {
        $this->gs = Generalsetting::findOrFail(1);
    }
    
    // user register
    
    // user login
    public function login($request)
    {
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if(Auth::guard('web')->user()->email_verified == 0)
            {
              Auth::guard('web')->logout();
              return ['status' => 0 , 'message' => __('Your Email is not Verified!')];   
            }
            LoginLogs::create([
                'user_id' => auth()->id(),
                'ip' => @loginIp()->geoplugin_request,
                'country' => @loginIp()->geoplugin_countryName,
                'city' => @loginIp()->geoplugin_city,
            ]);
            return true;   
        }else{
            return ['status' => 0 , 'message' => __("Credentials Doesn\'t Match !")];   
        }
    }

    
}


