<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Baris ini wajib ada agar Laravel tahu letak file controllernya
use App\Http\Controllers\WisataController; 

// Ini adalah "alamat" yang dihubungi oleh Axios dari frontend tadi
Route::post('/rekomendasi-wisata', [WisataController::class, 'getRekomendasi']);

// ==========================================
// ROUTE AUTENTIKASI API
// ==========================================
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'apiLogin']);

// ==========================================
// ROUTE CRUD API UNTUK POSTMAN / FRONTEND
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pengunjung', [\App\Http\Controllers\Admin\KelolaPengunjungController::class, 'apiIndex']);
    Route::post('/pengunjung', [\App\Http\Controllers\Admin\KelolaPengunjungController::class, 'store']);
    Route::get('/pengunjung/{id}', [\App\Http\Controllers\Admin\KelolaPengunjungController::class, 'show']);
    Route::put('/pengunjung/{id}', [\App\Http\Controllers\Admin\KelolaPengunjungController::class, 'apiUpdate']);
    Route::delete('/pengunjung/{id}', [\App\Http\Controllers\Admin\KelolaPengunjungController::class, 'apiDestroy']);
});
