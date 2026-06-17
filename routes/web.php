<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Tambahan untuk memanggil DashboardController

// Halaman Utama
Route::get('/', function () {
    return view('home');
});

// Route untuk pengguna yang BELUM LOGIN (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk pengguna yang SUDAH LOGIN (Auth)
Route::middleware('auth')->group(function () {
    // Route halaman dashboard baru
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route logout yang sudah ada (dipindahkan ke dalam grup ini biar lebih rapi)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});