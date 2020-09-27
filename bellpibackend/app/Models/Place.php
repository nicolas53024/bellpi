<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'type_vehicle_id',
        'vehicle_id',
    ];
    public function vehicle(){
        return $this->hasOne(Vehicle::class,'id','vehicle_id')
                    ->join('users as u','u.id','vehicles.user_id')
                    ->select('u.name','u.document','vehicles.*');
    }
}
