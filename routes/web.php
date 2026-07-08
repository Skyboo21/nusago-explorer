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
use App\Http\Controllers\Admin\KelolaReviewController;
use App\Http\Controllers\Admin\DatabaseGuideController;
use App\Http\Controllers\WisataController; 
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\SearchController;

// Route untuk pengguna yang BELUM LOGIN (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Halaman Utama (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('home');
});
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Route untuk pengguna yang SUDAH LOGIN (Auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil & Pengaturan
    Route::get('/profile/settings', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.settings');
    Route::put('/profile/settings', [\App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

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

    // Fitur Cari Terdekat (Kuliner API)
    Route::get('/api/kuliner/terdekat', [KulinerController::class, 'cariTerdekat'])->name('kuliner.terdekat');
});

// ==========================================
// FITUR TAMBAHAN PUBLIK (BISA DIAKSES SIAPA SAJA)
// ==========================================
Route::get('/destinasi', [WisataController::class, 'halamanDestinasi'])->name('destinasi');
Route::get('/detail-wisata', [WisataController::class, 'showDetail']);
Route::get('/pemandu-lokal', function () { return view('coming-soon', ['title' => 'Pemandu Lokal']); })->name('pemandu-lokal');

// Route Publik Kuliner
Route::get('/kuliner', [KulinerController::class, 'index'])->name('kuliner');
Route::get('/kuliner/{id}', [KulinerController::class, 'showDetail'])->name('kuliner.detail');


// ==========================================
// ROUTE ADMIN (WAJIB LOGIN & ROLE ADMIN)
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Kelola Pengunjung
    Route::get('/pengunjung', [KelolaPengunjungController::class, 'index'])->name('pengunjung.index');
    Route::get('/pengunjung/{id}/edit', [KelolaPengunjungController::class, 'edit'])->name('pengunjung.edit');
    Route::put('/pengunjung/{id}', [KelolaPengunjungController::class, 'update'])->name('pengunjung.update');
    Route::delete('/pengunjung/{id}', [KelolaPengunjungController::class, 'destroy'])->name('pengunjung.destroy');

    // Kelola Wisata
    Route::get('/wisata', [KelolaWisataController::class, 'index'])->name('wisata.index');
    Route::get('/wisata/create', [KelolaWisataController::class, 'create'])->name('wisata.create');
    Route::post('/wisata', [KelolaWisataController::class, 'store'])->name('wisata.store');
    Route::get('/wisata/{id}/edit', [KelolaWisataController::class, 'edit'])->name('wisata.edit');
    Route::put('/wisata/{id}', [KelolaWisataController::class, 'update'])->name('wisata.update');
    Route::delete('/wisata/{id}', [KelolaWisataController::class, 'destroy'])->name('wisata.destroy');

    // Kelola Kuliner Admin
    Route::get('/kuliner', [App\Http\Controllers\Admin\KelolaKulinerController::class, 'index'])->name('kuliner.index');
    Route::get('/kuliner/create', [App\Http\Controllers\Admin\KelolaKulinerController::class, 'create'])->name('kuliner.create');
    Route::post('/kuliner', [App\Http\Controllers\Admin\KelolaKulinerController::class, 'store'])->name('kuliner.store');
    Route::get('/kuliner/{id}/edit', [App\Http\Controllers\Admin\KelolaKulinerController::class, 'edit'])->name('kuliner.edit');
    Route::put('/kuliner/{id}', [App\Http\Controllers\Admin\KelolaKulinerController::class, 'update'])->name('kuliner.update');
    Route::delete('/kuliner/{id}', [App\Http\Controllers\Admin\KelolaKulinerController::class, 'destroy'])->name('kuliner.destroy');

    // Kelola Review
    Route::get('/review', [KelolaReviewController::class, 'index'])->name('review.index');
    Route::delete('/review/{id}', [KelolaReviewController::class, 'destroy'])->name('review.destroy');

    // Database Guide
    Route::get('/guide', [DatabaseGuideController::class, 'index'])->name('guide.index');
    Route::get('/guide/create', [DatabaseGuideController::class, 'create'])->name('guide.create');
    Route::post('/guide', [DatabaseGuideController::class, 'store'])->name('guide.store');
    Route::get('/guide/{id}/edit', [DatabaseGuideController::class, 'edit'])->name('guide.edit');
    Route::put('/guide/{id}', [DatabaseGuideController::class, 'update'])->name('guide.update');
    Route::delete('/guide/{id}', [DatabaseGuideController::class, 'destroy'])->name('guide.destroy');
});

Route::get('/explorer', function () {
    return view('explorer'); 
});

Route::get('/landing-page', function () {
    return view('landing-page');
});

// Route Khusus untuk Testing/Pembuktian API PENGUNJUNG di Praktikum
Route::get('/tes-api', function () {
    return view('tes-api');
});