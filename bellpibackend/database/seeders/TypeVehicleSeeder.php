<?php

namespace Database\Seeders;

use App\Models\TypeVehicle;
use Illuminate\Database\Seeder;

class TypeVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeVehicle::create([
            'name'=>'automovil'
        ]);
        TypeVehicle::create([
            'name'=>'moto'
        ]);
        TypeVehicle::create([
            'name'=>'bicicleta'
        ]);
       
    }
}
