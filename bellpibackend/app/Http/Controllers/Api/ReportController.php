<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SumaServicio;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function getPlace(Request $request){
        $from=\Carbon\Carbon::parse($request->from);
        $to=\Carbon\Carbon::parse($request->to);
        $place=SumaServicio::select('place_id',DB::raw('sum(minutes) as sm'),'p.name')->whereDate('inicio','>=',$from)->whereDate('inicio','<=',$to)
            ->groupBy('place_id')
            ->orderBy('sm','desc')->take(1)
            ->join('places as p','p.id','suma_servicios.place_id')
            ->get();
        return response()->json($place);
    }

    public  function getServicesByVehicle(Request $request){
        $from=\Carbon\Carbon::parse($request->from);
        $to=\Carbon\Carbon::parse($request->to);
        $vehicles=Vehicle::whereIn('id',function ($query) use($from,$to) {
            $query->select('vehicle_id')
                ->from('services')
                ->whereDate('services.inicio', '>=', $from)->whereDate('inicio', '<=', $to)->whereNotNull('services.final');
        })->with('servicesComplete')->get();
        return response()->json($vehicles);
    }

    public function countVehicles(Request $request){
        $from=\Carbon\Carbon::parse($request->from);
        $to=\Carbon\Carbon::parse($request->to);
        $count=Service::select('t.name as tipo',DB::raw('COUNT(*) as cantidad'))->
        whereBetween(DB::raw('DATE(inicio)'), [$from, $to])
            ->join('vehicles as v','v.id','services.vehicle_id')
            ->join('types_vehicles as t','t.id','v.type_vehicle_id')
            ->groupBy('tipo')
            ->get();
        return response()->json($count);
    }
    public function earningsReport(Request $request){
        $from=\Carbon\Carbon::parse($request->from);
        $to=\Carbon\Carbon::parse($request->to);
        $amounts=Service::whereBetween(DB::raw('DATE(inicio)'), [$from, $to])->
        select(DB::raw('CAST(inicio as DATE) AS fecha, sum(final_price) as amount'))
            ->groupBy(DB::raw('CAST(inicio as DATE)'))->get();
        return response()->json($amounts);
    }
}
