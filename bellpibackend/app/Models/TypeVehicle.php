<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeVehicle extends Model
{
    use HasFactory;
    protected $table='types_vehicles';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
