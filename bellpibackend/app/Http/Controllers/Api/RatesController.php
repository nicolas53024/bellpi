<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRatePost;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RatesController extends Controller
{
    public function getRates()
    {
        $rates=Rate::join('types_vehicles as t','rates.type_vehicle_id','t.id')
            ->select('rates.*','t.name')->get();
        return response()->json($rates);
    }
    public function updateRate(UpdateRatePost $request,Rate $rate){
        $rate->update([
            'rate_per_minute' => $request->rate,
        ]);
    }
}
