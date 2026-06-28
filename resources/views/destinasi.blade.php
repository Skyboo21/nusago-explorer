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
        <h1 class="fw-bold" style="color: var(--color-foreground);">Destinasi Terpopuler</h1>
        <p class="text-muted" style="color: var(--color-foreground) !important; opacity: 0.8;">Jelajahi tempat wisata yang sedang tren dan paling banyak dikunjungi.</p>
    </div>

    <div class="row g-4 mb-5">
        @forelse($destinasiPopuler as $wisata)
            <div class="col-md-4">
                <div class="glass-card h-100 border-0 rounded-4 overflow-hidden" style="transition: transform 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    @php
                        if (Str::startsWith($wisata->gambar, 'http') || Str::startsWith($wisata->gambar, 'data:')) {
                            $imgSrc = $wisata->gambar;
                        } else {
                            $imgSrc = asset('img/' . $wisata->gambar);
                        }
                    @endphp
                    <img src="{{ $imgSrc }}" class="card-img-top" alt="{{ $wisata->nama_wisata }}" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body position-relative text-start p-4">
                        <div class="position-absolute top-0 end-0 translate-middle-y me-4 bg-warning text-dark px-3 py-1 rounded-pill shadow-sm fw-bold border border-white border-2" style="z-index: 2;">
                            <i class="fa-solid fa-star text-dark me-1"></i> {{ $wisata->rating ?? 'N/A' }}
                        </div>

                        <h5 class="card-title fw-bold mt-3 mb-3" style="color: var(--color-foreground); font-size: 1.25rem;">{{ $wisata->nama_wisata }}</h5>
                        
                        <div class="d-flex flex-column gap-2 mb-4">
                            <div class="d-flex align-items-start small" style="color: var(--color-foreground); opacity: 0.85;">
                                <i class="fa-solid fa-location-dot mt-1 me-2" style="color: var(--color-accent); width: 14px; text-align: center;"></i>
                                <span>{{ $wisata->alamat }}</span>
                            </div>
                            
                            <div class="d-flex align-items-center small" style="color: var(--color-foreground); opacity: 0.85;">
                                <i class="fa-solid fa-fire me-2" style="color: var(--color-accent); width: 14px; text-align: center;"></i> 
                                <span>{{ number_format($wisata->jumlah_pengunjung ?? 0) }} orang telah berkunjung</span>
                            </div>
                        </div>

                        <p class="card-text small m-0" style="color: var(--color-foreground); opacity: 0.7; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">
                            {{ $wisata->deskripsi }}
                        </p>
                    </div>
                    
                    <div class="card-footer border-0 pb-3 text-center" style="background: transparent;">
                        <a href="/detail-wisata?nama={{ urlencode($wisata->nama_wisata) }}" class="btn btn-custom w-100">
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
        <div class="glass-card p-5 rounded-4 shadow-lg border" style="max-width: 500px;">
            <i class="fa-solid fa-lock fa-3x mb-3" style="color: var(--color-accent);"></i>
            <h3 class="fw-bold" style="color: var(--color-foreground);">Akses Terbatas</h3>
            <p class="mb-4" style="color: var(--color-foreground); opacity: 0.8;">Untuk melihat informasi lengkap dan fitur destinasi wisata, silakan login/register terlebih dahulu.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-custom px-4">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-dark px-4 rounded-pill fw-bold" style="border-color: var(--color-border); color: var(--color-foreground);">Daftar</a>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection