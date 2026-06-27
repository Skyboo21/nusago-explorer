@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    <div class="py-3 px-4" style="background: linear-gradient(135deg, #e63946, #c1121f);">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="text-white">
                <h5 class="fw-bold mb-0">{{ $selected['nama'] }}</h5>
                <small class="opacity-75"><i class="fa-solid fa-location-dot me-1"></i>{{ $selected['lokasi'] }}</small>
            </div>
            <a href="{{ route('virtual-camera.index') }}" class="btn btn-outline-light btn-sm rounded-3">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div style="height:500px; width:100%;">
        <iframe width="100%" height="100%" frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/streetview?key={{ env('GOOGLE_MAPS_API_KEY') }}&location={{ $selected['lat'] }},{{ $selected['lng'] }}&heading=210&pitch=10&fov=90"
            allowfullscreen>
        </iframe>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width:50px; height:50px; background:#fff0f0;">
                            <i class="fa-solid fa-camera text-danger fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">{{ $selected['nama'] }}</h5>
                            <span class="badge rounded-pill" style="background:#fff0f0; color:#e63946;">
                                {{ $selected['kategori'] }}
                            </span>
                        </div>
                    </div>
                    <p class="text-secondary">{{ $selected['deskripsi'] }}</p>
                    <div class="row g-3 mt-2">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2 bg-light rounded-3 p-3">
                                <i class="fa-solid fa-location-dot text-danger"></i>
                                <div>
                                    <small class="text-muted d-block">Lokasi</small>
                                    <span class="fw-semibold">{{ $selected['lokasi'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2 bg-light rounded-3 p-3">
                                <i class="fa-solid fa-map-pin text-danger"></i>
                                <div>
                                    <small class="text-muted d-block">Koordinat</small>
                                    <span class="fw-semibold">{{ $selected['lat'] }}, {{ $selected['lng'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a href="https://maps.google.com/?q={{ $selected['lat'] }},{{ $selected['lng'] }}"
                            target="_blank" class="btn btn-outline-danger rounded-3">
                            <i class="fa-solid fa-map-location-dot me-2"></i>Buka di Google Maps
                        </a>
                        <a href="{{ route('review.index') }}" class="btn text-white rounded-3" style="background:#e63946;">
                            <i class="fa-solid fa-star me-2"></i>Tulis Review
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Destinasi Lainnya</h6>
                @foreach($destinasi as $d)
                    @if($d['nama'] !== $selected['nama'])
                        <a href="{{ route('virtual-camera.show', ['nama' => $d['nama']]) }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2 text-decoration-none text-dark"
                            style="background:#f8f9fa; transition:background 0.2s;"
                            onmouseover="this.style.background='#fff0f0'"
                            onmouseout="this.style.background='#f8f9fa'">
                            <img src="{{ $d['foto'] }}" class="rounded-3 flex-shrink-0"
                                width="60" height="45" style="object-fit:cover;"
                                onerror="this.src='https://via.placeholder.com/60x45'">
                            <div>
                                <div class="fw-semibold small">{{ $d['nama'] }}</div>
                                <small class="text-muted">{{ $d['lokasi'] }}</small>
                            </div>
                            <i class="fa-solid fa-chevron-right text-danger ms-auto"></i>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
