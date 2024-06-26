<?php

use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\UserController;
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

 //Endpoint de Users
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/paginate', [UserController::class, 'paginate']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{email}', [UserController::class, 'show']);
Route::put('/users/{email}', [UserController::class, 'update']);
Route::delete('/users/{email}', [UserController::class, 'destroy']);

// Route::apiResource('/users', UserController::class);
// Route::get('/users/paginate', [UserController::class, 'paginate']);

Route::middleware('auth:sanctum')->group(function() {

    Route::get('hello/world', [\App\Http\Controllers\HelloController::class, 'index']);

    Route::resource('schedules', ScheduleController::class)
         ->only([
            'store', 'update', 'destroy'
        ]);

    Route::match(['get', 'post'], '/schedules/list', [ScheduleController::class, 'index']);

});



