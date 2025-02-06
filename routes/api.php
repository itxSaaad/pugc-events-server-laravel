<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RSVPController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});


// Public Routes (No Authentication required)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected Routes (Authentication required)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('events', [EventController::class, 'index']);
    Route::get('events/{id}', [EventController::class, 'show']);

    Route::get('events/user/rsvp', [RSVPController::class, 'index']);
    Route::get('events/{eventId}/rsvp', [RSVPController::class, 'getEventRSVPs']);
    Route::post('events/{eventId}/rsvp', [RSVPController::class, 'store']);
    Route::delete('events/{eventId}/rsvp', [RSVPController::class, 'destroy']);

    // Protected routes with admin role
    Route::middleware('role:admin')->group(function () {
        Route::post('events', [EventController::class, 'store']);
        Route::put('events/{id}', [EventController::class, 'update']);
        Route::delete('events/{id}', [EventController::class, 'destroy']);
    });
});
