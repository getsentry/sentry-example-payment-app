<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\DummyDataController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('v1')->group(function () {
    Route::apiResource('payments', PaymentController::class);
    Route::post('/generate-dummy-data', [DummyDataController::class, 'generate']);
    Route::post('/cleanup-dummy-data', [DummyDataController::class, 'cleanup']);
}); 