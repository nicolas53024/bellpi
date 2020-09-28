<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumaServicio extends Model
{
    use HasFactory;
    protected $table='suma_servicios';
    public $timestamps = false;
}
