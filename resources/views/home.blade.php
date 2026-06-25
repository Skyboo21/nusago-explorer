@extends('layouts.app')

@section('content')
<style>
    .hero-section {
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
        margin: -60px auto 50px auto;
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

    /* --- Tambahan CSS untuk Carousel --- */
    .carousel-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding-bottom: 20px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch; /* Efek smooth di iOS */
        scrollbar-width: thin; /* Firefox */
        scrollbar-color: #e63946 #f1f1f1;
    }
    .carousel-wrapper::-webkit-scrollbar {
        height: 8px;
    }
    .carousel-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1; 
        border-radius: 10px;
    }
    .carousel-wrapper::-webkit-scrollbar-thumb {
        background: #e63946; 
        border-radius: 10px;
    }
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
                <button type="submit" class="btn btn-danger w-100 py-2"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari Sekarang</button>
            </div>
        </form>
    </div>
</div>

<!-- === SECTION BARU: REKOMENDASI LOKASI CAROUSEL === -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="section-title mb-0" style="margin-bottom: 0 !important;">📍 Ada Apa di Sekitarmu?</h3>
        <!-- Tombol untuk trigger permintaan lokasi -->
        <button onclick="cariWisataTerdekat()" id="btn-lokasi" class="btn btn-outline-primary rounded-pill px-4">
            <i class="fa-solid fa-location-crosshairs me-2"></i>Aktifkan Lokasi
        </button>
    </div>

    <!-- Status Teks (Loading/Error) -->
    <div id="status-lokasi" class="text-muted mb-3" style="display: none;"></div>

    <!-- Wadah Carousel -->
    <div id="carousel-rekomendasi" class="carousel-wrapper" style="display: none;">
        <!-- Hasil kartu wisata akan disuntikkan oleh Javascript di sini -->
    </div>
</section>
<!-- ================================================= -->

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

<!-- Pastikan CDN Axios terpasang -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function cariWisataTerdekat() {
        const statusDiv = document.getElementById('status-lokasi');
        const carousel = document.getElementById('carousel-rekomendasi');
        const btn = document.getElementById('btn-lokasi');
        
        statusDiv.style.display = 'block';
        statusDiv.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Meminta akses lokasi...';
        carousel.style.display = 'none';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (posisi) => {
                    statusDiv.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mencari destinasi di sekitarmu...';
                    kirimKeBackend(posisi.coords.latitude, posisi.coords.longitude);
                },
                (error) => {
                    statusDiv.innerHTML = 'Menampilkan rekomendasi populer...';
                    kirimKeBackend(-7.5504, 110.8316); 
                }
            );
        } else {
            statusDiv.innerHTML = "Browser tidak mendukung fitur lokasi.";
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
                statusDiv.innerHTML = "Belum ada destinasi yang terdeteksi di area ini.";
                return;
            }

            statusDiv.style.display = 'none';
            carousel.style.display = 'flex';
            
            let html = '';
            tempatWisata.forEach(tempat => {
                if(tempat.tags && tempat.tags.name) {
                    const tipe = tempat.tags.tourism || 'Wisata';
                    
                    // KUNCI PERUBAHAN: Bikin URL dinamis yang membawa nama wisata ke halaman detail
                    let urlDetail = `/detail-wisata?nama=${encodeURIComponent(tempat.tags.name)}`;
                    
                    html += `
                    <div class="card card-feature carousel-card shadow-sm border-0">
                        <div class="carousel-img-placeholder">
                            <i class="fa-solid fa-image fa-3x"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-truncate" title="${tempat.tags.name}">${tempat.tags.name}</h5>
                            <p class="card-text text-muted small mb-3"><i class="fa-solid fa-tag text-danger me-2"></i>${tipe}</p>
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