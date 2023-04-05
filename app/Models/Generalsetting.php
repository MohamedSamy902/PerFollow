<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generalsetting extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $casts = ['cookie'=>'object','api_actions'=>'array']; 
    protected $table = 'generalsettings';
    protected $guarded = ['id'];

    

} 
