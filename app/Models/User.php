<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'referred_by',
        'photo',
        'phone',
        'country',
        'city',
        'email_verified',
        'verification_link',
        'address',
        'status',
        'zip',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
    }

    public function deposit()
    {
        return $this->hasMany(Deposit::class,'user_id');
    }

    public function referBonusCount()
    {
       return $this->transactions()->where('remark','deposit_referral_bonus')->count();
    }


    protected static function boot(){
        parent::boot();
        static::created(function($user){
            LoginLogs::create([
                'user_id' => auth()->id(),
                'ip' => @loginIp()->geoplugin_request,
                'country' => @loginIp()->geoplugin_countryName,
                'city' => @loginIp()->geoplugin_city,
            ]);
        });
    }
    
   

   
}
