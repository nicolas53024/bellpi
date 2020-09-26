<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function getUserBySerial(Request $request){
        $vehicle=Vehicle::where('placa',$request->placa)->with('user')->firstOrFail();
        return response()->json($vehicle);
    }

    public function getPlaces(){
        $places=Place::all();
        return response()->json($places);
    }

    public function storeService(Request $request){
        Log::info($request);
        try{
            DB::beginTransaction();
            $user = User::firstOrNew([
                'document' =>  request('user')->document,
                'name' =>  request('user')->name,
                ]);
            $vehicle=Vehicle::firstOrNew([

            ]);
        }catch (\Throwable $th){
            Log::info($th);
            return response()->json("fallo el registro", 422);
        }

    }
}
