<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0 ; $i <10  ; $i++) { 
            Place::create([
                'name'=>"A".($i+1),
                'type_vehicle_id'=>1,
            ]);
        }
        for ($i=0 ; $i <20  ; $i++) { 
            Place::create([
                'name'=>"M".($i+1),
                'type_vehicle_id'=>2,
            ]);
        }
        for ($i=0 ; $i <10  ; $i++) { 
            Place::create([
                'name'=>"B".($i+1),
                'type_vehicle_id'=>3,
            ]);
        }
    }
}
