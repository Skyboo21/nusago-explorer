@extends('layouts.app')

@section('title', 'Wisata Kuliner Nusantara')

@section('content')
<div class="py-4 bg-light min-vh-100 {{ auth()->guest() ? 'relative h-[85vh] overflow-hidden' : 'relative' }}">
    <div class="container max-w-7xl mx-auto px-4">
        
        <!-- HEADER SECTION -->
        <div class="text-center mb-4">
            <h1 id="mainTitle" class="fw-bold text-dark mb-2 fs-1" style="letter-spacing: -0.5px;">Jelajah Rasa Nusantara </h1>
            <p class="text-muted mx-auto mb-4" style="max-width: 600px; font-size: 1rem;">
                Temukan kuliner khas terdekat atau cari hidangan favoritmu di seluruh Indonesia.
            </p>
        </div>

        <!-- SEARCH & ACTION BAR -->
        <div class="bg-white p-2 rounded-pill shadow-sm border mb-4 d-flex align-items-center gap-2">
            <div class="flex-grow-1 d-flex align-items-center px-3">
                <i class="fa-solid fa-search text-muted me-2"></i>
                <input type="text" id="searchInput" class="form-control border-0 shadow-none p-0 bg-transparent" 
                       placeholder="Cari nama makanan atau daerah..." onkeyup="filterSearch()">
            </div>
            
            <div class="vr h-100 mx-1 d-none d-md-block"></div>

            <div class="d-flex gap-2 pe-1 flex-wrap">
                <!-- Tombol Terdekat (Tetap pakai API karena butuh GPS) -->
                <button id="btnNearby" class="btn btn-accent rounded-pill px-4 py-2 fw-semibold d-flex align-items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-location-crosshairs"></i> <span class="d-none d-sm-inline">Terdekat</span>
                </button>
                
                <!-- ✅ DROPDOWN SEKITAR WISATA (VERSI AMAN: FILTER LOKAL TANPA API) -->
                <div class="dropdown">
                    <button class="btn btn-outline-warning rounded-pill px-3 dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                         Sekitar Wisata
                    </button>
                    <ul class="dropdown-menu border-0 shadow-sm rounded-3 mt-2" style="max-height: 300px; overflow-y: auto;">
                        <li><a class="dropdown-item py-2" href="#" onclick="filterByWisata('all')">Tampilkan Semua</a></li>
                        @forelse(\App\Models\Wisata::all() as $wisata)
                            <li>
                                <a class="dropdown-item py-2" href="#" 
                                   onclick="filterByWisata({{ $wisata->id }}, '{{ addslashes($wisata->nama_wisata) }}')">
                                    {{ $wisata->nama_wisata }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">Belum ada data destinasi</span></li>
                        @endforelse
                    </ul>
                </div>

                <!-- Filter Status Halal -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary rounded-pill px-3 dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                        Status Halal
                    </button>
                    <ul class="dropdown-menu border-0 shadow-sm rounded-3 mt-2">
                        <li><a class="dropdown-item py-2" href="#" onclick="filterHalal('all')">Semua</a></li>
                        <li><a class="dropdown-item py-2" href="#" onclick="filterHalal('halal')">✅ Halal</a></li>
                        <li><a class="dropdown-item py-2" href="#" onclick="filterHalal('non-halal')"> Non-Halal</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- LOADING STATE (Hanya untuk tombol Terdekat) -->
        <div id="loadingState" class="text-center py-5 d-none">
            <div class="spinner-border text-warning mb-3" role="status"></div>
            <p class="text-muted fw-medium">Mencari lokasi sekitarmu...</p>
        </div>

        <!-- EMPTY STATE -->
        <div id="emptyState" class="text-center py-5 d-none">
            <i class="fa-solid fa-utensils text-muted mb-3 fs-1"></i>
            <h6 class="fw-bold text-dark">Tidak ada kuliner ditemukan</h6>
            <p class="text-muted small">Coba ganti kata kunci atau filter lainnya</p>
        </div>

        <!-- GRID KULINER -->
        <div id="kulinerGrid" class="row g-3">
            @forelse($kuliners as $item)
                @php
                    $fallbackImg = 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500&q=80';
                    $imageUrl = $item->gambar_kuliner ? asset('storage/' . $item->gambar_kuliner) : $fallbackImg;
                @endphp
                
                <!-- Tambahkan data-wisata-id untuk filter lokal -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 item-kuliner" 
                     data-name="{{ strtolower($item->nama_kuliner) }}" 
                     data-region="{{ strtolower($item->daerah ?? '') }}"
                     data-halal="{{ $item->is_halal ? 'yes' : 'no' }}"
                     data-wisata-id="{{ $item->wisata_id ?? 'none' }}">
                    
                    <a href="{{ route('kuliner.detail', $item->id) }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all bg-white">
                            <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                                <img src="{{ $imageUrl }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->nama_kuliner }}">
                                <span class="position-absolute top-0 end-0 m-3 badge badge-glass text-dark fw-bold shadow-sm px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-location-dot text-accent me-1"></i>{{ $item->daerah ?? 'Lokal' }}
                                </span>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title fw-bold text-dark mb-0 lh-base" style="font-size: 1.1rem; letter-spacing: -0.3px;">{{ $item->nama_kuliner }}</h6>
                                    <div class="d-flex align-items-center gap-1 bg-warning bg-opacity-10 px-2 py-1 rounded-3">
                                        <i class="fa-solid fa-star text-warning" style="font-size: 0.7rem;"></i>
                                        <small class="fw-bold text-warning" style="font-size: 0.8rem;">{{ number_format($item->rating ?? 0, 1) }}</small>
                                    </div>
                                </div>
                                <p class="text-accent fw-semibold mb-3" style="font-size: 0.85rem;">Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i></p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top border-light">
                                    <span class="badge {{ $item->is_halal ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }} fw-medium px-2 py-1 rounded-2" style="font-size: 0.7rem;">
                                        {!! $item->is_halal ? '<i class="fa-solid fa-certificate me-1"></i>Halal' : '<i class="fa-solid fa-circle-exclamation me-1"></i>Non-Halal' !!}
                                    </span>
                                    <span class="text-dark fw-bold" style="font-size: 1rem;">
                                        {{ $item->harga_estimasi > 0 ? 'Rp ' . number_format($item->harga_estimasi, 0, ',', '.') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5 my-5">
                    <i class="fa-solid fa-utensils text-muted mb-3 fs-1 opacity-25"></i>
                    <h5 class="fw-bold text-dark">Belum ada data kuliner</h5>
                </div>
            @endforelse
        </div>

    </div>

    @guest
        <div class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white/40 backdrop-blur-[12px] pt-10">
            <div class="bg-white/95 backdrop-blur-xl p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/50 text-center max-w-lg mx-4 relative overflow-hidden">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120px] bg-primary/20 blur-[50px] rounded-full pointer-events-none"></div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-900 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i data-lucide="lock" class="h-10 w-10 text-white"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 mb-3 font-heading tracking-tight">Akses Terbatas</h3>
                    <p class="text-slate-600 mb-8 leading-relaxed font-medium">Silakan login/register untuk menjelajahi kuliner.</p>
                    <div class="flex justify-center gap-4 w-full">
                        <a href="{{ route('login') }}" class="flex-1 inline-flex items-center justify-center rounded-full bg-primary px-8 py-3.5 text-sm font-bold text-white shadow-md hover:bg-teal-800 transition-all active:scale-95 text-decoration-none border-0">Login</a>
                        <a href="{{ route('register') }}" class="flex-1 inline-flex items-center justify-center rounded-full bg-white px-8 py-3.5 text-sm font-bold text-slate-900 shadow-sm hover:bg-gray-50 transition-all active:scale-95 text-decoration-none border-2 border-slate-200 hover:border-slate-300">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    @endguest
</div>

<style>
    .text-accent { color: #F59E0B !important; }
    .bg-accent { background-color: #F59E0B !important; color: white !important; }
    .btn-accent { background-color: #F59E0B; color: white; border: none; transition: all 0.3s ease; }
    .btn-accent:hover { background-color: #d97706; color: white; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3); }
    .badge-glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.3); }
    .hover-shadow { transition: transform 0.3s ease, box-shadow 0.3s ease; border: 1px solid rgba(0,0,0,0.05); }
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
    .object-fit-cover { object-fit: cover; }
    #searchInput:focus { outline: none; box-shadow: none; }
</style>

<script>
    // 1. PENCARIAN NAMA/DAERAH
    function filterSearch() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.item-kuliner').forEach(item => {
            const name = item.dataset.name || '';
            const region = item.dataset.region || '';
            item.style.display = (name.includes(query) || region.includes(query)) ? 'block' : 'none';
        });
    }

    // 2. FILTER HALAL
    function filterHalal(type) {
        document.querySelectorAll('.item-kuliner').forEach(item => {
            const isHalal = item.dataset.halal === 'yes';
            if (type === 'all') item.style.display = 'block';
            else if (type === 'halal' && isHalal) item.style.display = 'block';
            else if (type === 'non-halal' && !isHalal) item.style.display = 'block';
            else item.style.display = 'none';
        });
    }

    // ✅ 3. FILTER SEKITAR WISATA (LOKAL SAJA - TANPA API)
    function filterByWisata(wisataId, namaWisata) {
        const title = document.getElementById('mainTitle');
        const grid = document.getElementById('kulinerGrid');
        const empty = document.getElementById('emptyState');
        let visibleCount = 0;

        if (wisataId === 'all') {
            title.innerHTML = 'Jelajah Rasa Nusantara 🍜';
            document.querySelectorAll('.item-kuliner').forEach(item => item.style.display = 'block');
            return;
        }

        title.innerHTML = `Kuliner Sekitar ${namaWisata} 🏞️`;
        
        document.querySelectorAll('.item-kuliner').forEach(item => {
            // Tampilkan jika wisata_id nya cocok
            if (item.dataset.wisataId == wisataId) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            grid.classList.add('d-none');
            empty.classList.remove('d-none');
            empty.querySelector('p').innerText = `Belum ada kuliner yang terkait dengan ${namaWisata}.`;
        } else {
            grid.classList.remove('d-none');
            empty.classList.add('d-none');
        }
    }

    // 4. FITUR TERDEKAT (MASIH PAKAI API GPS)
    document.getElementById('btnNearby').addEventListener('click', function() {
        const loading = document.getElementById('loadingState');
        const grid = document.getElementById('kulinerGrid');
        const empty = document.getElementById('emptyState');
        const title = document.getElementById('mainTitle');

        loading.classList.remove('d-none');
        grid.classList.add('d-none');
        empty.classList.add('d-none');
        title.innerHTML = 'Kuliner Terdekat Dari Lokasimu ';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    fetch(`/api/kuliner/terdekat?lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
                        .then(response => response.json())
                        .then(data => {
                            loading.classList.add('d-none');
                            renderCardsFromAPI(data);
                        })
                        .catch(() => {
                            loading.classList.add('d-none');
                            alert("Gagal memuat lokasi.");
                            title.innerHTML = 'Jelajah Rasa Nusantara 🍜';
                        });
                },
                () => {
                    loading.classList.add('d-none');
                    grid.classList.remove('d-none');
                    alert("Aktifkan GPS untuk fitur ini.");
                    title.innerHTML = 'Jelajah Rasa Nusantara ';
                }
            );
        }
    });

    // Helper untuk render hasil API GPS (tetap dibutuhkan untuk tombol Terdekat)
    function renderCardsFromAPI(data) {
        const grid = document.getElementById('kulinerGrid');
        const empty = document.getElementById('emptyState');
        grid.innerHTML = ''; 
        
        if (data.length > 0) {
            grid.classList.remove('d-none');
            empty.classList.add('d-none');
            data.forEach(item => {
                const imageUrl = item.gambar_kuliner ? '/storage/' + item.gambar_kuliner : 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500&q=80';
                const halalBadge = item.is_halal 
                    ? '<span class="badge bg-success bg-opacity-10 text-success fw-medium px-2 py-1 rounded-2" style="font-size: 0.7rem;"><i class="fa-solid fa-certificate me-1"></i>Halal</span>'
                    : '<span class="badge bg-danger bg-opacity-10 text-danger fw-medium px-2 py-1 rounded-2" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-exclamation me-1"></i>Non-Halal</span>';
                
                grid.innerHTML += `
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <a href="/kuliner/${item.id}" class="text-decoration-none text-dark d-block h-100">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all bg-white">
                                <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                                    <img src="${imageUrl}" class="w-100 h-100 object-fit-cover" alt="${item.nama_kuliner}">
                                    <span class="position-absolute top-0 end-0 m-3 badge badge-glass text-dark fw-bold shadow-sm px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-location-dot text-accent me-1"></i>${item.daerah || 'Sekitar Anda'}
                                    </span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title fw-bold text-dark mb-0 lh-base" style="font-size: 1.1rem;">${item.nama_kuliner}</h6>
                                        <div class="d-flex align-items-center gap-1 bg-warning bg-opacity-10 px-2 py-1 rounded-3">
                                            <i class="fa-solid fa-star text-warning" style="font-size: 0.7rem;"></i>
                                            <small class="fw-bold text-warning" style="font-size: 0.8rem;">${parseFloat(item.rating || 0).toFixed(1)}</small>
                                        </div>
                                    </div>
                                    <p class="text-accent fw-semibold mb-3" style="font-size: 0.85rem;">Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i></p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top border-light">
                                        ${halalBadge}
                                        <span class="text-dark fw-bold" style="font-size: 1rem;">Rp ${new Intl.NumberFormat('id-ID').format(item.harga_estimasi || 0)}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>`;
            });
        } else {
            grid.classList.add('d-none');
            empty.classList.remove('d-none');
        }
    }
</script>
@endsection