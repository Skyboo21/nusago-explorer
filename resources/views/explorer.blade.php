@extends('layouts.app')

@section('content')
<div class="container my-5 d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="glass-card p-5 rounded-4 shadow-lg border-0 text-center" style="max-width: 600px; width: 100%;">
        <div class="mb-4">
            <i class="fa-solid fa-map-location-dot fa-4x" style="color: var(--color-primary);"></i>
        </div>
        <h2 class="fw-bold mb-3" style="color: var(--color-foreground);">Temukan Wisata di Sekitarmu</h2>
        <p class="mb-4" style="color: var(--color-foreground); opacity: 0.8;">Izinkan akses lokasi untuk menemukan destinasi wisata menakjubkan yang berada di dekat Anda.</p>
        
        <button onclick="cariWisataTerdekat()" class="btn btn-custom btn-lg rounded-pill px-5 shadow w-100" style="font-size: 1.1rem;">
            <i class="fa-solid fa-location-crosshairs me-2"></i> Cari Wisata Terdekat
        </button>

        <div id="hasil-rekomendasi" class="mt-4 text-start"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function cariWisataTerdekat() {
        const hasilDiv = document.getElementById('hasil-rekomendasi');
        
        if (navigator.geolocation) {
            hasilDiv.innerHTML = `<div class="text-center my-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2" style="color: var(--color-foreground);">Meminta izin lokasi...</p></div>`;
            
            navigator.geolocation.getCurrentPosition(
                (posisi) => {
                    // User klik Allow
                    kirimKeBackend(posisi.coords.latitude, posisi.coords.longitude);
                },
                (error) => {
                    // User klik Block atau error
                    console.log("Akses ditolak. Memakai koordinat default (Surakarta).");
                    kirimKeBackend(-7.5666, 110.8283); 
                }
            );
        } else {
            alert("Browser tidak mendukung fitur lokasi.");
        }
    }

    function kirimKeBackend(lat, lng) {
        const hasilDiv = document.getElementById('hasil-rekomendasi');
        hasilDiv.innerHTML = `<div class="text-center my-4"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2" style="color: var(--color-foreground);">Mencari tempat wisata dari server...</p></div>`;
        
        // Tembak ke API Laravel yang sudah kamu buat di routes/api.php
        axios.post('/api/rekomendasi-wisata', {
            latitude: lat,
            longitude: lng
        })
        .then(function (response) {
            const tempatWisata = response.data.data;
            
            if(tempatWisata.length === 0) {
                hasilDiv.innerHTML = `<div class="alert alert-warning border-0 glass-card mt-3" style="color: var(--color-foreground);">Tidak ada tempat wisata terdeteksi di sekitarmu.</div>`;
                return;
            }

            // Susun HTML untuk ditampilkan
            let html = '<div class="list-group list-group-flush rounded-3 overflow-hidden mt-3 shadow-sm">';
            tempatWisata.forEach(tempat => {
                if(tempat.tags && tempat.tags.name) {
                    const tipe = tempat.tags.tourism || 'Wisata';
                    html += `
                        <div class="list-group-item bg-white bg-opacity-75 d-flex align-items-center py-3 border-bottom" style="border-color: rgba(0,0,0,0.05) !important;">
                            <div class="bg-light rounded-circle p-3 me-3 text-center" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-map-pin text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold" style="color: var(--color-foreground);">${tempat.tags.name}</h6>
                                <small class="text-muted"><i class="fa-solid fa-tag me-1"></i> ${tipe}</small>
                            </div>
                        </div>`;
                }
            });
            html += '</div>';
            
            // Tampilkan ke layar
            hasilDiv.innerHTML = html;
        })
        .catch(function (error) {
            hasilDiv.innerHTML = `<div class="alert alert-danger border-0 glass-card mt-3">Terjadi kesalahan saat memuat data wisata.</div>`;
            console.error(error);
        });
    }
</script>
@endsection