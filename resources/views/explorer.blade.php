<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusa Go Explorer - Sekitarku</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .btn { padding: 10px 20px; background: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .tempat-item { padding: 10px; border-bottom: 1px solid #ccc; }
    </style>
</head>
<body>

    <h2>Temukan Wisata di Sekitarmu</h2>
    
    <button onclick="cariWisataTerdekat()" class="btn">
        📍 Cari Wisata Terdekat
    </button>

    <div id="hasil-rekomendasi" style="margin-top: 20px;">
        </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function cariWisataTerdekat() {
            const hasilDiv = document.getElementById('hasil-rekomendasi');
            
            if (navigator.geolocation) {
                hasilDiv.innerHTML = "<p>Meminta izin lokasi...</p>";
                
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
            hasilDiv.innerHTML = "<p>Mencari tempat wisata dari server...</p>";
            
            // Tembak ke API Laravel yang sudah kamu buat di routes/api.php
            axios.post('/api/rekomendasi-wisata', {
                latitude: lat,
                longitude: lng
            })
            .then(function (response) {
                const tempatWisata = response.data.data;
                
                if(tempatWisata.length === 0) {
                    hasilDiv.innerHTML = "<p>Tidak ada tempat wisata terdeteksi di sekitarmu.</p>";
                    return;
                }

                // Susun HTML untuk ditampilkan
                let html = '<ul>';
                tempatWisata.forEach(tempat => {
                    if(tempat.tags && tempat.tags.name) {
                        const tipe = tempat.tags.tourism || 'Wisata';
                        html += `<li class="tempat-item"><strong>${tempat.tags.name}</strong> <br><small>Kategori: ${tipe}</small></li>`;
                    }
                });
                html += '</ul>';
                
                // Tampilkan ke layar
                hasilDiv.innerHTML = html;
            })
            .catch(function (error) {
                hasilDiv.innerHTML = "<p>Terjadi kesalahan saat memuat data wisata.</p>";
                console.error(error);
            });
        }
    </script>
</body>
</html>