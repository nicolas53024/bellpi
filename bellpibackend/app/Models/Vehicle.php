<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'placa',
        'type_vehicle_id',
        'user_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function servicesComplete(){
        return $this->hasMany(Service::class,'vehicle_id','id');
    }
}
