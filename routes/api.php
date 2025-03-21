<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ResourceController;
use App\Http\Controllers\Api\V1\BookingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware(['throttle:api'])->group(function () {
    Route::post('register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
});

Route::prefix('v1')->middleware(['throttle:api', 'auth:sanctum'])->group(function() {
    Route::apiResource('resources', ResourceController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::get('resources/{id}/bookings', [ResourceController::class, 'bookings']);
    Route::get('logout', [AuthController::class, 'logout']);
});