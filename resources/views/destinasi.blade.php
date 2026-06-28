@extends('layouts.app')

@section('content')
<style>
    /* --- CSS untuk Carousel Lokasi --- */
    .carousel-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding-bottom: 20px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch; 
        scrollbar-width: thin; 
        scrollbar-color: #e63946 #f1f1f1;
    }
    .carousel-wrapper::-webkit-scrollbar { height: 8px; }
    .carousel-wrapper::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .carousel-wrapper::-webkit-scrollbar-thumb { background: #e63946; border-radius: 10px; }
    
    .carousel-card {
        min-width: 280px;
        scroll-snap-align: start;
        flex: 0 0 auto;
    }
    .carousel-img-placeholder {
        height: 160px;
        background-color: #e9ecef;
        border-radius: 15px 15px 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }
</style>

@guest
<div class="position-relative">
    <div style="filter: blur(8px); pointer-events: none; user-select: none; opacity: 0.6;">
@endguest

<div class="container my-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #1d3557;">Destinasi Terpopuler</h1>
        <p class="text-muted">Jelajahi tempat wisata yang sedang tren dan paling banyak dikunjungi.</p>
    </div>

    <div class="row g-4 mb-5">
        @forelse($destinasiPopuler as $wisata)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    @php
                        if (Str::startsWith($wisata->gambar, 'http') || Str::startsWith($wisata->gambar, 'data:')) {
                            $imgSrc = $wisata->gambar;
                        } else {
                            $imgSrc = asset('img/' . $wisata->gambar);
                        }
                    @endphp
                    <img src="{{ $imgSrc }}" class="card-img-top" alt="{{ $wisata->nama_wisata }}" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body position-relative">
                        <div class="position-absolute top-0 end-0 translate-middle-y me-3 bg-warning text-dark px-3 py-1 rounded-pill shadow-sm fw-bold">
                            <i class="fa-solid fa-star text-white"></i> {{ $wisata->rating ?? 'N/A' }}
                        </div>

                        <h5 class="card-title fw-bold mt-2">{{ $wisata->nama_wisata }}</h5>
                        <p class="text-muted small mb-2"><i class="fa-solid fa-location-dot text-danger me-2"></i>{{ $wisata->alamat }}</p>
                        
                        <div class="d-flex align-items-center mb-3 text-muted small">
                            <i class="fa-solid fa-fire text-danger me-2"></i> {{ number_format($wisata->jumlah_pengunjung ?? 0) }} orang telah berkunjung
                        </div>

                        <p class="card-text text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $wisata->deskripsi }}
                        </p>
                    </div>
                    
                    <div class="card-footer bg-white border-0 pb-3 text-center">
                        <a href="/detail-wisata?nama={{ urlencode($wisata->nama_wisata) }}" class="btn btn-outline-danger w-100 rounded-pill">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Belum ada data destinasi wisata di database.</h4>
            </div>
        @endforelse
    </div>

</div>

@guest
    </div>
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center" style="z-index: 10;">
        <div class="bg-white p-5 rounded-4 shadow border" style="max-width: 500px;">
            <i class="fa-solid fa-lock text-danger fa-3x mb-3"></i>
            <h3 class="fw-bold text-dark">Akses Terbatas</h3>
            <p class="text-muted mb-4">Untuk melihat informasi lengkap dan fitur destinasi wisata, silakan login/register terlebih dahulu.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-danger px-4 rounded-pill fw-bold">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-danger px-4 rounded-pill fw-bold">Daftar</a>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection