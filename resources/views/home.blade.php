@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        /* Gambar background bisa kamu ganti nanti dengan file lokal seperti rajaampat.jpg */
        background: linear-gradient(rgba(29, 53, 87, 0.6), rgba(29, 53, 87, 0.3)), url('https://images.unsplash.com/photo-1570213489059-0aac6626cade?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
        height: 80vh;
        display: flex;
        align-items: center;
        color: white;
        text-align: center;
    }
    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 15px rgba(0,0,0,0.7);
    }
    .search-box {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        max-width: 900px;
        margin: -60px auto 50px auto; /* Membuat kotak melayang menabrak hero section */
        position: relative;
        z-index: 10;
    }
    .card-feature {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        background: white;
    }
    .card-feature:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .icon-box {
        width: 80px;
        height: 80px;
        background-color: #ffe8e8;
        color: #e63946;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 20px auto;
    }
    .section-title {
        color: #1d3557;
        font-weight: 700;
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
    }
    .section-title::after {
        content: '';
        width: 60px;
        height: 4px;
        background-color: #e63946;
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
</style>

<section class="hero-section">
    <div class="container">
        <h1 class="mb-4">Eksplorasi Tanpa Batas di Nusantara</h1>
        <p class="lead fw-light">Temukan destinasi tersembunyi, cicipi kuliner otentik, dan dengarkan cerita langsung dari pemandu lokal.</p>
    </div>
</section>

<div class="container">
    <div class="search-box">
        <form class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted fw-bold">Mau ke mana?</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fa-solid fa-location-dot text-danger"></i></span>
                    <input type="text" class="form-control" placeholder="Contoh: Bali, Solo, Bromo...">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted fw-bold">Apa yang dicari?</label>
                <select class="form-select">
                    <option>Semua (Wisata, Pemandu, Kuliner)</option>
                    <option>Hanya Destinasi Wisata</option>
                    <option>Pemandu Lokal (Tour Guide)</option>
                    <option>Rekomendasi Kuliner</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-custom w-100 py-2"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari Sekarang</button>
            </div>
        </form>
    </div>
</div>

<section class="container my-5 py-4">
    <div class="text-center mb-5">
        <h2 class="section-title">Platform Wisata Terintegrasi Pertama</h2>
    </div>
    
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card card-feature p-4 h-100 shadow-sm">
                <div class="icon-box"><i class="fa-solid fa-mountain-sun"></i></div>
                <h4 class="fw-bold">Destinasi Menawan</h4>
                <p class="text-muted">Jelajahi informasi lengkap mengenai tempat wisata di Indonesia, mulai dari harga tiket hingga rute perjalanan terbaik.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-feature p-4 h-100 shadow-sm">
                <div class="icon-box"><i class="fa-solid fa-users-viewfinder"></i></div>
                <h4 class="fw-bold">Pemandu Lokal</h4>
                <p class="text-muted">Perjalanan lebih aman dan bermakna dengan ditemani warga asli daerah yang siap menjadi Tour Guide andalanmu.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-feature p-4 h-100 shadow-sm">
                <div class="icon-box"><i class="fa-solid fa-bowl-food"></i></div>
                <h4 class="fw-bold">Rasa Otentik</h4>
                <p class="text-muted">Tidak perlu bingung mencari makan. Kami merekomendasikan kuliner legendaris dan kantin lokal persis di sekitar lokasi wisatamu.</p>
            </div>
        </div>
    </div>
</section>
@endsection