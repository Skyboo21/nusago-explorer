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
<div class="relative h-[85vh] overflow-hidden">
    <div style="filter: blur(8px); pointer-events: none; user-select: none; opacity: 0.6;">
@endguest

<div class="container max-w-7xl mx-auto px-4 my-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: var(--color-foreground);">Destinasi Terpopuler</h1>
        <p class="text-muted" style="color: var(--color-foreground) !important; opacity: 0.8;">Jelajahi tempat wisata yang sedang tren dan paling banyak dikunjungi.</p>
    </div>

    <div class="row g-4 mb-5">
        @forelse($destinasiPopuler as $wisata)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
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
                    
                    <div class="card-footer border-0 pb-3 px-4 text-center" style="background: transparent;">
                        <a href="/detail-wisata?nama={{ urlencode($wisata->nama_wisata) }}" class="inline-flex items-center justify-center rounded-2xl bg-primary w-full py-3 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 transition-all active:scale-95 text-decoration-none group">
                            Lihat Detail <i data-lucide="arrow-right" class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"></i>
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
    <!-- Blurry overlay over the content -->
    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white/40 backdrop-blur-[12px] pt-10">
        <!-- The Lock Card -->
        <div class="bg-white/95 backdrop-blur-xl p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/50 text-center max-w-lg mx-4 relative overflow-hidden">
            
            <!-- Glow Effect -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120px] bg-primary/20 blur-[50px] rounded-full pointer-events-none"></div>

            <div class="relative z-10 flex flex-col items-center">
                <!-- Lock Icon -->
                <div class="w-20 h-20 bg-slate-900 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <i data-lucide="lock" class="h-10 w-10 text-white"></i>
                </div>

                <h3 class="text-3xl font-bold text-slate-900 mb-3 font-heading tracking-tight">Akses Terbatas</h3>
                
                <p class="text-slate-600 mb-8 leading-relaxed font-medium">
                    Untuk melihat informasi lengkap dan fitur destinasi wisata, silakan login/register terlebih dahulu.
                </p>
                
                <div class="flex justify-center gap-4 w-full">
                    <a href="{{ route('login') }}" class="flex-1 inline-flex items-center justify-center rounded-full bg-primary px-8 py-3.5 text-sm font-bold text-white shadow-md hover:bg-teal-800 transition-all active:scale-95 text-decoration-none border-0">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex-1 inline-flex items-center justify-center rounded-full bg-white px-8 py-3.5 text-sm font-bold text-slate-900 shadow-sm hover:bg-gray-50 transition-all active:scale-95 text-decoration-none border-2 border-slate-200 hover:border-slate-300">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection