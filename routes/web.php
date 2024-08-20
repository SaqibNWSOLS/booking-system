<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceImageController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('service-detail/{id}', [HomeController::class, 'serviceDetail']);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('services', ServiceController::class);

    Route::post('service_image', [ServiceImageController::class, 'store']);
    Route::post('service_image_delete', [ServiceImageController::class, 'destroy']);

    Route::get('uploaded_images/{id}', [ServiceImageController::class, 'getUploadedImages']);
    Route::get('service_images/{id}', [ServiceImageController::class, 'getPropertyImages']);

    Route::post('set-location', [HomeController::class, 'setLocation']);

    Route::resource('bookings', BookingController::class);

    Route::get('change-password', [ChangePasswordController::class, 'index']);
    Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');

});
