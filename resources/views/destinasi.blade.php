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

<div class="container my-5">
    
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #1d3557;">Destinasi Terpopuler</h1>
        <p class="text-muted">Jelajahi tempat wisata yang sedang tren dan paling banyak dikunjungi.</p>
    </div>

    <div class="row g-4 mb-5">
        @forelse($destinasiPopuler as $wisata)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="{{ asset('img/' . $wisata->gambar) }}" class="card-img-top" alt="{{ $wisata->nama_wisata }}" style="height: 200px; object-fit: cover;">
                    
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

    <hr class="my-5" style="border-color: #ccc;">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1d3557;">📍 Eksplorasi Sekitarmu</h2>
            <p class="text-muted mb-0 d-none d-md-block">Temukan permata tersembunyi yang ada di dekat posisimu saat ini.</p>
        </div>
        <button onclick="cariWisataTerdekat()" id="btn-lokasi" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-location-crosshairs me-2"></i>Aktifkan Lokasi
        </button>
    </div>

    <div id="status-lokasi" class="alert alert-info" style="display: none;"></div>

    <div id="carousel-rekomendasi" class="carousel-wrapper" style="display: none;">
        </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Fungsi ini sama persis dengan yang ada di Beranda (home)
    function cariWisataTerdekat() {
        const statusDiv = document.getElementById('status-lokasi');
        const carousel = document.getElementById('carousel-rekomendasi');
        
        statusDiv.style.display = 'block';
        statusDiv.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Meminta akses lokasi ke sistem...';
        carousel.style.display = 'none';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (posisi) => {
                    statusDiv.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mencari destinasi terdekat dari titikmu...';
                    kirimKeBackend(posisi.coords.latitude, posisi.coords.longitude);
                },
                (error) => {
                    statusDiv.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i>Akses lokasi ditolak. Menampilkan rekomendasi area default.';
                    kirimKeBackend(-7.5504, 110.8316); 
                }
            );
        } else {
            statusDiv.innerHTML = "Browser kamu tidak mendukung fitur lokasi.";
        }
    }

    function kirimKeBackend(lat, lng) {
        const statusDiv = document.getElementById('status-lokasi');
        const carousel = document.getElementById('carousel-rekomendasi');
        
        axios.post('/api/rekomendasi-wisata', {
            latitude: lat,
            longitude: lng
        })
        .then(function (response) {
            const tempatWisata = response.data.data;
            
            if(tempatWisata.length === 0) {
                statusDiv.innerHTML = "Belum ada destinasi yang terdeteksi di radius ini.";
                return;
            }

            statusDiv.style.display = 'none';
            carousel.style.display = 'flex';
            
            let html = '';
            tempatWisata.forEach(tempat => {
                if(tempat.tags && tempat.tags.name) {
                    const tipe = tempat.tags.tourism || 'Wisata';
                    let urlDetail = `/detail-wisata?nama=${encodeURIComponent(tempat.tags.name)}`;
                    
                    html += `
                    <div class="card card-feature carousel-card shadow-sm border-0 rounded-4">
                        <div class="carousel-img-placeholder">
                            <i class="fa-solid fa-map-location-dot fa-3x"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-truncate" title="${tempat.tags.name}">${tempat.tags.name}</h5>
                            <p class="card-text text-muted small mb-3"><i class="fa-solid fa-tag text-danger me-2"></i>${tipe.replace('_', ' ')}</p>
                            <a href="${urlDetail}" class="btn btn-outline-danger w-100 rounded-pill">Lihat Detail</a>
                        </div>
                    </div>`;
                }
            });
            
            carousel.innerHTML = html;
        })
        .catch(function (error) {
            statusDiv.innerHTML = "<span class='text-danger'>Terjadi kesalahan saat memuat data.</span>";
            console.error(error);
        });
    }
</script>
@endsection