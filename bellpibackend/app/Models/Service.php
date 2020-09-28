<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = array(
        'user_id',
        'vehicle_id',
        'place_id',
        'final',
        'final_price',
        'minutes',
    );

}
