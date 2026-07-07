@extends('layouts.app')

@section('title', $kuliner->nama_kuliner . ' - NusaGo Explorer')

@section('content')
<div class="bg-light min-vh-100 pb-5">
    
    <!-- 1. HERO IMAGE FULL WIDTH -->
    <div class="position-relative w-100" style="height: 50vh; min-height: 350px;">
        @php
            $imgUrl = $kuliner->gambar_kuliner ? asset('storage/' . $kuliner->gambar_kuliner) : 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&q=80';
        @endphp
        
        <img src="{{ $imgUrl }}" 
             class="w-100 h-100" 
             style="object-fit: cover; object-position: center;" 
             alt="{{ $kuliner->nama_kuliner }}">
             
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, transparent 40%, transparent 60%, rgba(0,0,0,0.6) 100%);"></div>

        <a href="{{ url()->previous() }}" 
           class="position-absolute top-4 start-4 btn btn-white bg-white/90 backdrop-blur-sm rounded-circle shadow-sm d-flex align-items-center justify-center" 
           style="width: 45px; height: 45px; z-index: 10;">
            <i class="fa-solid fa-arrow-left text-dark"></i>
        </a>
    </div>

    <!-- 2. CONTENT AREA (OVERLAP EFFECT) -->
    <div class="container position-relative z-2" style="margin-top: -80px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Main Info Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4 bg-white">
                    <div class="card-body p-4 p-md-5">
                        
                        <!-- Header Title & Badges -->
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4 border-bottom pb-4">
                            <div>
                                <h1 class="fw-bold text-dark mb-2 fs-2 lh-base">{{ $kuliner->nama_kuliner }}</h1>
                                <div class="d-flex align-items-center gap-2 text-muted">
                                    <i class="fa-solid fa-location-dot text-accent"></i>
                                    <span class="fw-medium">{{ $kuliner->daerah ?? 'Lokasi Tidak Diketahui' }}</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center gap-1 bg-warning bg-opacity-10 px-3 py-2 rounded-pill border border-warning border-opacity-25">
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <span class="fw-bold text-warning">{{ number_format($kuliner->rating ?? 0, 1) }}</span>
                                </div>
                                
                                @if($kuliner->is_halal)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-semibold d-flex align-items-center gap-1">
                                        <i class="fa-solid fa-certificate"></i> Halal
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-2 rounded-pill fw-semibold">
                                        Non-Halal
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center h-100 hover-lift">
                                    <i class="fa-solid fa-tag text-primary mb-2 fs-4"></i>
                                    <p class="text-muted small mb-1">Harga</p>
                                    <h6 class="fw-bold text-dark m-0">{{ $kuliner->harga_estimasi > 0 ? 'Rp ' . number_format($kuliner->harga_estimasi, 0, ',', '.') : '-' }}</h6>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center h-100 hover-lift">
                                    <i class="fa-regular fa-clock text-info mb-2 fs-4"></i>
                                    <p class="text-muted small mb-1">Jam Buka</p>
                                    <h6 class="fw-bold text-dark m-0" style="font-size: 0.9rem;">{{ $kuliner->jam_operasional ?? '-' }}</h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 bg-accent-light rounded-3 text-center h-100 hover-lift">
                                    <i class="fa-solid fa-map-pin text-accent mb-2 fs-4"></i>
                                    <p class="text-muted small mb-1">Daerah</p>
                                    <h6 class="fw-bold text-dark m-0 text-truncate">{{ Str::limit($kuliner->daerah, 20) ?? '-' }}</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-info text-accent"></i> Tentang Kuliner Ini
                            </h5>
                            <p class="text-muted lh-lg mb-0">{{ $kuliner->deskripsi_kuliner ?? 'Deskripsi belum tersedia.' }}</p>
                        </div>

                        <!-- ✅ ACTION BUTTONS (HANYA PETUNJUK ARAH) -->
                        @if($kuliner->link_maps)
                            <div class="mt-4 pt-3 border-top">
                                <a href="{{ $kuliner->link_maps }}" target="_blank" class="btn btn-accent rounded-pill px-4 py-3 fw-bold shadow-sm w-100 d-flex align-items-center justify-content-center gap-2 hover-scale">
                                    <i class="fa-solid fa-map-location-dot"></i> Buka Petunjuk Arah di Google Maps
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .text-accent { color: #F59E0B !important; }
    .bg-accent-light { background-color: rgba(245, 158, 11, 0.08); }
    
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    
    .hover-scale { transition: all 0.2s ease; }
    .hover-scale:hover { transform: scale(1.02); }
    
    .btn-accent { background-color: #F59E0B; color: white; border: none; }
    .btn-accent:hover { background-color: #d97706; color: white; }
</style>
@endsection