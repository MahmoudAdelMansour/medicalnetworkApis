<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PrescriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. All routes here are automatically
| prefixed with "/api". We further version them under "/api/v1".
*/

Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('auth/login', [UserController::class, 'login'])->name('api.v1.auth.login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [UserController::class, 'logout'])->name('api.v1.auth.logout');
        Route::get('auth/whoam', [UserController::class, 'whoam'])->name('api.v1.auth.whoam');
        Route::post('auth/refresh', [UserController::class, 'refresh'])->name('api.v1.auth.refresh');
    });

    // Users CRUD
    Route::apiResource('users', UserController::class)->names('api.v1.users');

    // Medicines CRUD
    Route::apiResource('medicines', MedicineController::class)->names('api.v1.medicines');

    // Pharmacies CRUD
    Route::apiResource('pharmacies', PharmacyController::class)->names('api.v1.pharmacies');

    // Prescriptions CRUD
    Route::apiResource('prescriptions', PrescriptionController::class)->names('api.v1.prescriptions');

    // Custom: Fetch prescriptions by user and medicines by pharmacy
    Route::get('users/{user}/prescriptions', [PrescriptionController::class, 'byUser'])->name('api.v1.users.prescriptions');
    Route::get('pharmacies/{pharmacy}/medicines', [MedicineController::class, 'byPharmacy'])->name('api.v1.pharmacies.medicines');
});
