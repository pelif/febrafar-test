<?php

use App\Http\Controllers\API\ScheduleController;
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

Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {

    Route::get('hello/world', [\App\Http\Controllers\HelloController::class, 'index']);

    Route::resource('schedules', ScheduleController::class)
         ->only([
            'store', 'update', 'destroy'
        ]);

    Route::match(['get', 'post'], '/schedules/list', [ScheduleController::class, 'index']);

});



