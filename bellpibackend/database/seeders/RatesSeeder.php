<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Seeder;

class RatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <3 ; $i++) {
            Rate::create([
                'type_vehicle_id'=>$i+1,
                'rate_per_minute'=>100*($i+1),
            ]);
        }
    }
}
