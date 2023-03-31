<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\RemindController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
    
});
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user',function (Request $request){
        return [
            $request->user()
        ];
    }); 
    Route::post('logout', 'App\Http\Controllers\API\AuthController@logout');   
    Route::get('home', 'App\Http\Controllers\API\EventController@index');
    Route::get('home/remind', 'App\Http\Controllers\API\EventController@reminds');
    Route::get('home/event', 'App\Http\Controllers\API\EventController@events');
    Route::controller(EventController::class)->group(function(){
        Route::post('/event/create','create');
        Route::post('/remind/create','createRemind');
        Route::put('/event/edit/{id}','update');
        Route::put('/remind/edit/{id}','updateremind');
        Route::delete('/event/edit/{id}','delete');
        Route::get('/home/search','search');
    });
});

