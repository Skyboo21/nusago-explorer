@extends('layouts.app')

@section('title', 'Wisata Kuliner Nusantara')

@section('content')
<div class="py-4 bg-light min-vh-100 {{ auth()->guest() ? 'relative h-[85vh] overflow-hidden' : 'relative' }}">
    <div class="container max-w-7xl mx-auto px-4">
        
        <!-- HEADER SECTION -->
        <div class="text-center mb-4">
            <h1 id="mainTitle" class="fw-bold text-dark mb-2 fs-1" style="letter-spacing: -0.5px;">Jelajah Rasa Nusantara 🍜</h1>
            <p class="text-muted mx-auto mb-4" style="max-width: 600px; font-size: 1rem;">
                Temukan kuliner khas terdekat atau cari hidangan favoritmu di seluruh Indonesia.
            </p>
        </div>

        <!-- SEARCH & ACTION BAR -->
        <div class="bg-white p-2 rounded-pill shadow-sm border mb-4 d-flex align-items-center gap-2">
            <div class="flex-grow-1 d-flex align-items-center px-3">
                <i class="fa-solid fa-search text-muted me-2"></i>
                <input type="text" id="searchInput" class="form-control border-0 shadow-none p-0 bg-transparent" placeholder="Cari makanan atau daerah...">
            </div>
            
            <div class="vr h-100 mx-1 d-none d-md-block"></div>

            <div class="d-flex gap-2 pe-1 flex-wrap">
                <!-- Tombol Terdekat (GPS User) -->
                <button id="btnNearby" class="btn btn-accent rounded-pill px-4 py-2 fw-semibold d-flex align-items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-location-crosshairs"></i> <span class="d-none d-sm-inline">Terdekat</span>
                </button>
                
                <!-- Dropdown Sekitar Wisata -->
                <div class="dropdown">
                    <button class="btn btn-outline-warning rounded-pill px-3 dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                        📍 Sekitar Wisata
                    </button>
                    <ul class="dropdown-menu border-0 shadow-sm rounded-3 mt-2" style="max-height: 300px; overflow-y: auto;">
                        @forelse($destinasiKuliners as $destinasi)
                            <li>
                                <a class="dropdown-item py-2" href="#" 
                                   onclick="searchNearbyWisata({{ $destinasi->latitude }}, {{ $destinasi->longitude }}, '{{ addslashes($destinasi->nama_destinasi) }}')">
                                    {{ $destinasi->nama_destinasi }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">Belum ada data destinasi</span></li>
                        @endforelse
                    </ul>
                </div>

                <!-- Dropdown Kategori -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary rounded-pill px-3 dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                        Kategori
                    </button>
                    <ul class="dropdown-menu border-0 shadow-sm rounded-3 mt-2">
                        <li><a class="dropdown-item py-2" href="#" onclick="filterCategory('all')">Semua</a></li>
                        <li><a class="dropdown-item py-2" href="#" onclick="filterCategory('restoran')">Restoran</a></li>
                        <li><a class="dropdown-item py-2" href="#" onclick="filterCategory('kafe')">Kafe & Warkop</a></li>
                        <li><a class="dropdown-item py-2" href="#" onclick="filterCategory('street_food')">Street Food</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- LOADING STATE -->
        <div id="loadingState" class="text-center py-5 d-none">
            <div class="spinner-border text-warning mb-3" role="status"></div>
            <p class="text-muted fw-medium">Mencari kuliner di sekitarmu...</p>
        </div>

        <!-- EMPTY STATE -->
        <div id="emptyState" class="text-center py-5 d-none">
            <i class="fa-solid fa-utensils text-muted mb-3 fs-1"></i>
            <h6 class="fw-bold text-dark">Tidak ada kuliner ditemukan</h6>
            <p class="text-muted small">Coba perbesar radius pencarian atau ganti kata kunci</p>
        </div>

        <!-- GRID KULINER (DINAMIS DARI DATABASE AWAL) -->
        <div id="kulinerGrid" class="row g-3">
            @forelse($kuliners as $item)
                @php
                    $foodImages = [
                        'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500&q=80',
                        'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=500&q=80',
                        'https://images.unsplash.com/photo-1572656631137-7935297eff55?w=500&q=80',
                        'https://images.unsplash.com/photo-1564834724105-918b73d1b9e0?w=500&q=80'
                    ];
                    $fallbackImg = $foodImages[$loop->index % count($foodImages)];
                @endphp
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 item-kuliner" data-type="{{ $item->kategori }}">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all bg-white">
                        <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                            <img src="{{ $item->gambar_kuliner ?? $fallbackImg }}" 
                                 class="w-100 h-100 object-fit-cover" alt="{{ $item->nama_kuliner }}">
                            <span class="position-absolute top-0 end-0 m-3 badge badge-glass text-dark fw-bold shadow-sm px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-location-dot text-accent me-1"></i>{{ $item->daerah }}
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h6 class="card-title fw-bold text-dark mb-0 lh-base" style="font-size: 1.1rem; letter-spacing: -0.3px;">{{ $item->nama_kuliner }}</h6>
                                <div class="d-flex align-items-center gap-1 bg-accent bg-opacity-10 px-2 py-1 rounded-3">
                                    <i class="fa-solid fa-star text-accent" style="font-size: 0.7rem;"></i>
                                    <small class="fw-bold text-accent" style="font-size: 0.8rem;">{{ number_format($item->rating, 1) }}</small>
                                </div>
                            </div>
                            <p class="card-text text-muted mb-4 text-truncate" style="font-size: 0.85rem; line-height: 1.5;">{{ Str::limit($item->deskripsi_kuliner, 50) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top border-light">
                                <span class="badge {{ $item->is_halal ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }} fw-medium px-2 py-1 rounded-2" style="font-size: 0.7rem;">
                                    {!! $item->is_halal ? '<i class="fa-solid fa-certificate me-1"></i>Halal' : '<i class="fa-solid fa-circle-exclamation me-1"></i>Non-Halal' !!}
                                </span>
                                <span class="text-dark fw-bold" style="font-size: 1rem;">{{ $item->harga_estimasi > 0 ? 'Rp ' . number_format($item->harga_estimasi, 0, ',', '.') : 'Rp 25k - 50k' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 my-5">
                    <i class="fa-solid fa-utensils text-muted mb-3 fs-1 opacity-25"></i>
                    <h5 class="fw-bold text-dark">Belum ada data kuliner</h5>
                    <p class="text-muted">Data akan segera ditambahkan oleh admin.</p>
                </div>
            @endforelse
        </div>

    </div>

    @guest
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
                        Untuk menjelajahi daftar kuliner dan fitur lokasi terdekat, silakan login/register terlebih dahulu.
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
    // HELPER FUNCTION BUAT AMBIL DATA HYBRID (DB + OVERPASS)
    function getVal(item, key, fallback = '') {
        return (item.tags && item.tags[key]) ? item.tags[key] : (item[key] || fallback);
    }

    // LOGIKA FILTER KATEGORI (Hanya untuk data awal dari DB)
    function filterCategory(type) {
        const items = document.querySelectorAll('.item-kuliner');
        items.forEach(item => {
            if (type === 'all' || item.dataset.type === type) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // FUNGSI RENDER CARD (Digunakan oleh kedua fitur pencarian)
    function renderCards(data) {
        const grid = document.getElementById('kulinerGrid');
        const empty = document.getElementById('emptyState');
        
        grid.innerHTML = ''; 
        
        if (data.length > 0) {
            grid.classList.remove('d-none');
            empty.classList.add('d-none');
            
            data.forEach((item, index) => {
                const name = getVal(item, 'name') || getVal(item, 'nama_kuliner', 'Tanpa Nama');
                
                const foodImages = [
                    'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500&q=80',
                    'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=500&q=80',
                    'https://images.unsplash.com/photo-1572656631137-7935297eff55?w=500&q=80',
                    'https://images.unsplash.com/photo-1564834724105-918b73d1b9e0?w=500&q=80'
                ];
                const image = getVal(item, 'image') || 
                              getVal(item, 'gambar_kuliner') || 
                              foodImages[index % foodImages.length];
                              
                const region = getVal(item, 'region') || getVal(item, 'daerah', 'Sekitar Anda');
                const desc = getVal(item, 'description') || getVal(item, 'deskripsi_kuliner', 'Kuliner lezat di sekitar Anda yang patut dicoba.');
                const price = getVal(item, 'price') || getVal(item, 'harga_estimasi', 0);
                const isHalal = (getVal(item, 'is_halal') === 'yes' || getVal(item, 'is_halal') === true);
                const rating = getVal(item, 'rating') || 4.0;
                
                const formattedPrice = price > 0 ? `Rp ${new Intl.NumberFormat('id-ID').format(price)}` : 'Rp 15k - 30k';
                const halalBadge = isHalal 
                    ? '<span class="badge bg-success bg-opacity-10 text-success fw-medium px-2 py-1 rounded-2" style="font-size: 0.7rem;"><i class="fa-solid fa-certificate me-1"></i>Halal</span>'
                    : '<span class="badge bg-danger bg-opacity-10 text-danger fw-medium px-2 py-1 rounded-2" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-exclamation me-1"></i>Non-Halal</span>';

                const cardHtml = `
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all bg-white">
                            <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                                <img src="${image}" class="w-100 h-100 object-fit-cover" alt="${name}">
                                <span class="position-absolute top-0 end-0 m-3 badge badge-glass text-dark fw-bold shadow-sm px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-location-dot text-accent me-1"></i>${region}
                                </span>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h6 class="card-title fw-bold text-dark mb-0 lh-base" style="font-size: 1.1rem; letter-spacing: -0.3px;">${name}</h6>
                                    <div class="d-flex align-items-center gap-1 bg-accent bg-opacity-10 px-2 py-1 rounded-3">
                                        <i class="fa-solid fa-star text-accent" style="font-size: 0.7rem;"></i>
                                        <small class="fw-bold text-accent" style="font-size: 0.8rem;">${parseFloat(rating).toFixed(1)}</small>
                                    </div>
                                </div>
                                <p class="card-text text-muted mb-4 text-truncate" style="font-size: 0.85rem; line-height: 1.5;">${desc.substring(0, 50)}${desc.length > 50 ? '...' : ''}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top border-light">
                                    ${halalBadge}
                                    <span class="text-dark fw-bold" style="font-size: 1rem;">${formattedPrice}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                grid.innerHTML += cardHtml;
            });
        } else {
            grid.classList.add('d-none');
            empty.classList.remove('d-none');
        }
    }

    // FITUR 1: CARI TERDEKAT (GPS USER)
    document.getElementById('btnNearby').addEventListener('click', function() {
        const loading = document.getElementById('loadingState');
        const grid = document.getElementById('kulinerGrid');
        const empty = document.getElementById('emptyState');
        const title = document.getElementById('mainTitle');

        loading.classList.remove('d-none');
        grid.classList.add('d-none');
        empty.classList.add('d-none');
        title.innerHTML = 'Kuliner Terdekat Dari Lokasimu 📍';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    
                    fetch(`/api/kuliner/terdekat?lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            loading.classList.add('d-none');
                            renderCards(data);
                        })
                        .catch(err => {
                            console.error(err);
                            loading.classList.add('d-none');
                            alert("Gagal memuat data kuliner.");
                            title.innerHTML = 'Jelajah Rasa Nusantara ';
                        });
                },
                (error) => {
                    loading.classList.add('d-none');
                    grid.classList.remove('d-none');
                    alert("Gagal mendapatkan lokasi. Pastikan GPS aktif.");
                    title.innerHTML = 'Jelajah Rasa Nusantara 🍜';
                }
            );
        }
    });

    // FITUR 2: CARI SEKITAR WISATA
    function searchNearbyWisata(lat, lon, namaWisata) {
        const loading = document.getElementById('loadingState');
        const grid = document.getElementById('kulinerGrid');
        const empty = document.getElementById('emptyState');
        const title = document.getElementById('mainTitle');

        loading.classList.remove('d-none');
        grid.classList.add('d-none');
        empty.classList.add('d-none');
        title.innerHTML = `Kuliner Sekitar ${namaWisata} 🏞️`;

        fetch(`/api/kuliner/terdekat?lat=${lat}&lon=${lon}`)
            .then(response => response.json())
            .then(data => {
                loading.classList.add('d-none');
                renderCards(data);
            })
            .catch(err => {
                console.error(err);
                loading.classList.add('d-none');
                alert("Gagal memuat data kuliner.");
                title.innerHTML = 'Jelajah Rasa Nusantara 🍜';
            });
    }
</script>
@endsection