<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Blade\ApiUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


# Api Clients
Route::post('/login',[ApiAuthController::class,'login']);

Route::group(['middleware' => 'api-auth'],function (){
    Route::post('/me',[ApiAuthController::class,'me']);
    Route::post('/tokens',[ApiAuthController::class,'getAllTokens']);
    Route::post('/logout',[ApiAuthController::class,'logout']);
});

Route::group(['middleware' => 'ajax.check'],function (){
    Route::post('/api-user/toggle-status/{user_id}',[ApiUserController::class,'toggleUserActivation']);
    Route::post('/api-token/toggle-status/{token_id}',[ApiUserController::class,'toggleTokenActivation']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
