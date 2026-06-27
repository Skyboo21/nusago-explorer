<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\VirtualCameraController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KelolaPengunjungController;
use App\Http\Controllers\Admin\KelolaWisataController;
use App\Http\Controllers\Admin\DatabaseGuideController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Review & Rating
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
    Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');

    // Fitur Chatbot
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot/send', [ChatbotController::class, 'send'])->name('chatbot.send');
    Route::post('/chatbot/clear', [ChatbotController::class, 'clearHistory'])->name('chatbot.clear');

    // Fitur Kamera Virtual
    Route::get('/virtual-camera', [VirtualCameraController::class, 'index'])->name('virtual-camera.index');
    Route::get('/virtual-camera/show', [VirtualCameraController::class, 'show'])->name('virtual-camera.show');

    // Fitur Maps Real Time
    Route::get('/maps', function () {
        return view('maps.index');
    })->name('maps.index');
});

// Route Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Kelola Pengunjung
    Route::get('/pengunjung', [KelolaPengunjungController::class, 'index'])->name('pengunjung.index');
    Route::delete('/pengunjung/{id}', [KelolaPengunjungController::class, 'destroy'])->name('pengunjung.destroy');

    // Kelola Wisata
    Route::get('/wisata', [KelolaWisataController::class, 'index'])->name('wisata.index');

    // Database Guide
    Route::get('/guide', [DatabaseGuideController::class, 'index'])->name('guide.index');
    Route::get('/guide/create', [DatabaseGuideController::class, 'create'])->name('guide.create');
    Route::post('/guide', [DatabaseGuideController::class, 'store'])->name('guide.store');
    Route::get('/guide/{id}/edit', [DatabaseGuideController::class, 'edit'])->name('guide.edit');
    Route::put('/guide/{id}', [DatabaseGuideController::class, 'update'])->name('guide.update');
    Route::delete('/guide/{id}', [DatabaseGuideController::class, 'destroy'])->name('guide.destroy');
});
