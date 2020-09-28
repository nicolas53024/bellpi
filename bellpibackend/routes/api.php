<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DiscountController;
use App\Http\Controllers\api\RatesController;
use App\Http\Controllers\api\ReportController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/get-user', [ServiceController::class, 'getUserBySerial']);
    Route::get('/get-places', [ServiceController::class, 'getPlaces']);
    Route::post('/store-service', [ServiceController::class, 'storeService']);
    Route::get('/get-rates', [RatesController::class, 'getRates']);
    Route::post('/update-rate/{rate}', [RatesController::class, 'updateRate']);
    Route::get('/get-current-discount', [DiscountController::class, 'getCurrentDiscount']);
    Route::post('/update-discount/{discount}', [DiscountController::class, 'updateDiscount']);
    Route::post('/get-service', [ServiceController::class, 'getService']);
    Route::post('/end-service/{service}', [ServiceController::class, 'endService']);
    Route::post('/get-place-report',[ReportController::class,'getPlace']);
    Route::post('/get-vehicles-services-report',[ReportController::class,'getServicesByVehicle']);
    Route::post('/count-vehicles-report',[ReportController::class,'countVehicles']);
    Route::post('/earning-report',[ReportController::class,'earningsReport']);

});



