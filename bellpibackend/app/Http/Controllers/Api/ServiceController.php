<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Place;
use App\Models\Rate;
use App\Models\Service;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function getUserBySerial(Request $request){
        $vehicle=Vehicle::where('placa',$request->placa)->with('user')->firstOrFail();
        $place=Place::where('vehicle_id',$vehicle->id)->first();
        if($place){
            return response()->json("exists vehicle in place",422);
        }
        return response()->json($vehicle);
    }

    public function getPlaces(){
        $places=Place::with('vehicle')->get();
        return response()->json($places);
    }

    public function storeService(Request $request){
        try{
            DB::beginTransaction();
            $user = User::firstOrCreate([
                'document' =>  $request->service['user']['documento'],
                ],['name' =>  $request->service['user']['nombre']]);
            $vehicle=Vehicle::firstOrCreate([
                'placa'=>$request->service['placa'],
            ],[
                'type_vehicle_id'=>$request->service['typeVehicle'],
                'user_id'=>$user->id
            ]);
            if($request->service['idPlace'] == 0){
                $randomPlace=Place::inRandomOrder()->where('type_vehicle_id',$request->service['typeVehicle'])->whereNull('vehicle_id')->first();
            }
            $place=Place::where('id',$request->service['idPlace']==0?$randomPlace->id:$request->service['idPlace'])->update(['vehicle_id'=>$vehicle->id]);
            $service=Service::create([
                'user_id'=>$user->id,
                'vehicle_id'=>$vehicle->id,
                'place_id'=>$request->service['idPlace']==0?$randomPlace->id:$request->service['idPlace']
            ]);
            if(!$service){
                DB::rollBack();
                return response()->json("fallo el registro", 422);
            }
        }catch (\Throwable $th){
            Log::info($th);
            return response()->json("fallo el registro", 422);
        }
        DB::commit();
        if(isset($randomPlace)){
            return response()->json($randomPlace);
        }else{
            return response()->json($service);
        }

    }
    public function getService(Request $request){
        $placa=$request->placa;
        $service=Service::where('services.vehicle_id',function ($query) use($placa){
            $query->select('id')
                ->from('vehicles')
                ->where('placa',$placa);
        })->whereNull('final')
            ->join('users as u','services.user_id','u.id')
            ->join('places as p','services.place_id','p.id')
            ->join('vehicles as v','services.vehicle_id','v.id')
            ->join('types_vehicles as tv','v.type_vehicle_id','tv.id')
            ->select('services.id as service_id',"services.inicio",'u.name as username','u.document','v.placa','tv.name as tipo','p.name as sitio','v.type_vehicle_id as idType')->firstOrFail();
        return response()->json($service);
    }
    public function endService(Request $request,Service $service){
        $now = Carbon::now();
        $minuts = $now->diffInMinutes($service->inicio);
        $discount=Discount::where('minutes','>',0)->where('minutes','<=',$minuts)->first();
        $rate=Rate::where('type_vehicle_id',$request->idType)->select('rate_per_minute')->first();
        $rate=$rate->rate_per_minute;
        $totalAmount=$rate*$minuts;
        $response['amount']=$totalAmount;
        if($discount){
            $discountAmount=$totalAmount*($discount->percent/100);
            $totalAmount=$totalAmount-$discountAmount;
        }
        try {
            $service->update([
                'final' => $now,
                'final_price' => $totalAmount,
            ]);
            self::cleanPlace($service->place_id);
            $response['final_amount']=$totalAmount;
            $response['minuts']=$minuts;
            $response['discount']=$discountAmount??0;
            $response['percent']=$discount->percent??0;
            $response['exit']=$now;
            return response()->json($response);
        }catch (\Throwable $th){
            Log::info($th);
            return response()->json("fallo el registro", 422);
        }

    }
    public static function cleanPlace($id){
        Place::find($id)->update([
            'vehicle_id'=>null,
        ]);
    }
}
