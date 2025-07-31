<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LogoutController::class, 'logout']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/services', [ServiceController::class, 'index']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);

    // Admin
    Route::middleware('is.admin')->group(function () {
        Route::post('/services', [ServiceController::class, 'store']);
        Route::put('/services/{id}', [ServiceController::class, 'update']);
        Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
        Route::get('/admin/bookings', [AdminBookingController::class, 'index']);
    });
});




// Route::match(['post', 'put', 'patch', 'HEAD', 'OPTIONS', 'DELETE', 'GET'], 'blogs/{id?}', [BlogController::class, 'getAllOrOneOrDestroy']);
// Route::match(['post', 'put', 'patch', 'HEAD', 'OPTIONS'], 'blogs/{id?}', [BlogController::class, 'storeOrUpdate']);


Route::get('/test-auth', function () {
    $user = Auth::guard('api')->user();
    return response()->json([
        'user' => $user,
    ]);
});
