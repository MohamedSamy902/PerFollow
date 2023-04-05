<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getMinAmountAttribute($value)
    {
        return round($value, 2);
    }
    public function getMaxAmountAttribute($value)
    {
        return round($value, 2);
    }
    public function getPriceAttribute($value)
    {
        return round($value, 2);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'service_id','id');
    }
}
