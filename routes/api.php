<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Baris ini wajib ada agar Laravel tahu letak file controllernya
use App\Http\Controllers\WisataController; 

// Ini adalah "alamat" yang dihubungi oleh Axios dari frontend tadi
Route::post('/rekomendasi-wisata', [WisataController::class, 'getRekomendasi']);