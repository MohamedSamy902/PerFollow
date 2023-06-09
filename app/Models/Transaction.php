<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function currency()
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class,'user_id')->withDefault();
    }

    function bonusfrom()
    {
        return $this->belongsTo(User::class,'bonus_from')->withDefault();
    }
}
