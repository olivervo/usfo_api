<?php

use App\Actions\Spar\SearchSpar;
use App\Http\Controllers\CampController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Public routes
Route::get('/camps', [CampController::class, 'index']);
Route::get('/camps/{camp}', [CampController::class, 'show']);
Route::post('/registrations', [RegistrationController::class, 'store']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', MeController::class);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    Route::apiResource('/registrations', RegistrationController::class);
    Route::apiResource('/students', StudentController::class);
    Route::post('/spar', SearchSpar::class);
});
