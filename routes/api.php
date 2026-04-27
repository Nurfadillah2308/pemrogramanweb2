<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

Route::post('/login', [BarangController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/{id}', [BarangController::class, 'show']);

    Route::middleware('role:admin')->group(function () {
        Route::post('/barang', [BarangController::class, 'store']);
        Route::put('/barang/{id}', [BarangController::class, 'update']);
        Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});