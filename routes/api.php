<?php

use App\Http\Controllers\CampController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public routes
Route::get('/camps', [CampController::class, 'index']);
Route::get('/camps/{camp}', [CampController::class, 'show']);
Route::post('/registrations', [RegistrationController::class, 'store']);

// Staff routes

// Admin routes
Route::apiResource('/registrations', RegistrationController::class);
Route::apiResource('/students', StudentController::class);
