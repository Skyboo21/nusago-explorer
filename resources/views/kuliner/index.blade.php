@extends('layouts.app')

@section('title', 'Wisata Kuliner Nusantara')

@section('content')
<div class="py-4 bg-light min-vh-100">
    <div class="container">
        
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
                <button id="btnNearby" class="btn btn-danger rounded-pill px-3 fw-semibold d-flex align-items-center gap-2 btn-sm">
                    <i class="fa-solid fa-location-crosshairs"></i> <span class="d-none d-sm-inline">Terdekat</span>
                </button>
                
                <!-- Dropdown Sekitar Wisata -->
                <div class="dropdown">
                    <button class="btn btn-outline-danger rounded-pill px-3 dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
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
            <div class="spinner-border text-danger mb-3" role="status"></div>
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
                <div class="col-6 col-md-4 col-lg-3 item-kuliner" data-type="{{ $item->kategori }}">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="position-relative" style="height: 160px; overflow: hidden;">
                            <img src="{{ $item->gambar_kuliner ?? 'https://loremflickr.com/400/300/food?random=' . $item->id }}" 
                                 class="w-100 h-100 object-fit-cover" alt="{{ $item->nama_kuliner }}">
                            <span class="position-absolute top-0 start-0 m-2 badge bg-white text-danger fw-bold shadow-sm" style="font-size: 0.65rem;">
                                {{ $item->daerah }}
                            </span>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title fw-bold text-dark mb-0 lh-sm" style="font-size: 0.95rem;">{{ $item->nama_kuliner }}</h6>
                                <div class="d-flex align-items-center gap-1 bg-warning-subtle px-1 py-0 rounded-2">
                                    <i class="fa-solid fa-star text-warning" style="font-size: 0.6rem;"></i>
                                    <small class="fw-bold text-dark" style="font-size: 0.7rem;">{{ number_format($item->rating, 1) }}</small>
                                </div>
                            </div>
                            <p class="card-text text-muted mb-3 text-truncate" style="font-size: 0.8rem;">{{ Str::limit($item->deskripsi_kuliner, 50) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge {{ $item->is_halal ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} fw-medium" style="font-size: 0.65rem;">
                                    {{ $item->is_halal ? 'Halal' : 'Non-Halal' }}
                                </span>
                                <span class="text-danger fw-bold" style="font-size: 0.9rem;">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fa-solid fa-utensils text-muted mb-3 fs-1"></i>
                    <h6 class="fw-bold text-dark">Belum ada data kuliner</h6>
                    <p class="text-muted small">Data akan segera ditambahkan oleh admin.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

<style>
    .hover-shadow:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important; transition: all 0.3s ease; }
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
            
            data.forEach(item => {
                const name = getVal(item, 'name') || getVal(item, 'nama_kuliner', 'Tanpa Nama');
                const image = getVal(item, 'image') || 
                              getVal(item, 'gambar_kuliner') || 
                              `https://loremflickr.com/400/300/food,restaurant?random=${item.id}`;
                const region = getVal(item, 'region') || getVal(item, 'daerah', 'Lokal');
                const desc = getVal(item, 'description') || getVal(item, 'deskripsi_kuliner', 'Kuliner lezat di sekitar Anda.');
                const price = getVal(item, 'price') || getVal(item, 'harga_estimasi', 0);
                const isHalal = (getVal(item, 'is_halal') === 'yes' || getVal(item, 'is_halal') === true);
                const rating = getVal(item, 'rating') || 4.0;
                
                const cardHtml = `
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
                            <div class="position-relative" style="height: 160px; overflow: hidden;">
                                <img src="${image}" class="w-100 h-100 object-fit-cover" alt="${name}">
                                <span class="position-absolute top-0 start-0 m-2 badge bg-white text-danger fw-bold shadow-sm" style="font-size: 0.65rem;">${region}</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title fw-bold text-dark mb-0 lh-sm" style="font-size: 0.95rem;">${name}</h6>
                                    <div class="d-flex align-items-center gap-1 bg-warning-subtle px-1 py-0 rounded-2">
                                        <i class="fa-solid fa-star text-warning" style="font-size: 0.6rem;"></i>
                                        <small class="fw-bold text-dark" style="font-size: 0.7rem;">${parseFloat(rating).toFixed(1)}</small>
                                    </div>
                                </div>
                                <p class="card-text text-muted mb-3 text-truncate" style="font-size: 0.8rem;">${desc.substring(0, 50)}${desc.length > 50 ? '...' : ''}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge ${isHalal ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'} fw-medium" style="font-size: 0.65rem;">${isHalal ? 'Halal' : 'Non-Halal'}</span>
                                    <span class="text-danger fw-bold" style="font-size: 0.9rem;">Rp ${new Intl.NumberFormat('id-ID').format(price)}</span>
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