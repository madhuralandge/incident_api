<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'/v1'],function() {
	Route::get('/incident',	 	[App\Http\Controllers\api\v1\ApiController::class, 'getIncidents'])->name('incident.get');
	Route::post('/incident',	[App\Http\Controllers\api\v1\ApiController::class, 'storeIncidents'])->name('incident.store');
});