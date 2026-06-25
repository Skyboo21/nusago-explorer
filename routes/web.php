<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\WisataController; // <-- TAMBAHAN BARU

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
    
    // Route logout yang sudah ada 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/explorer', function () {
    return view('explorer'); 
});

// <-- TAMBAHAN ROUTE UNTUK HALAMAN DETAIL -->
Route::get('/detail-wisata', [WisataController::class, 'showDetail']);

// Tambahkan baris ini di routes/web.php
Route::get('/destinasi', [WisataController::class, 'halamanDestinasi'])->name('destinasi');