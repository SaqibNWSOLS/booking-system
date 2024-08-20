<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingsController;



Route::post('login',[AuthController::class,'login']);

Route::group(['middleware'=>'auth:api'],function(){

Route::resource('bookings',BookingsController::class);

});