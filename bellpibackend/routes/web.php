<?php

use App\Http\Controllers\api\AuthController;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $vehicle=Vehicle::where('placa',"QDM47E")->firstOrFail();
    dd($vehicle->user->name);
});
Auth::routes();
