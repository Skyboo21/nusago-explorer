@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto px-4 py-8 md:py-12">
    
    <!-- Header -->
    <div class="mb-10 text-center animate-[fadeIn_0.5s_ease-out]">
        <h1 class="text-3xl md:text-4xl font-bold font-heading text-foreground mb-3">Peta Wisata Real Time</h1>
        <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
            Temukan destinasi wisata terdekat dari lokasi kamu saat ini.
        </p>
    </div>

    <!-- Map Container -->
    <div class="mb-8 rounded-[2rem] border border-border bg-white shadow-sm overflow-hidden relative group p-2">
        <div class="rounded-[1.5rem] overflow-hidden relative">
            <div id="map" class="h-[400px] md:h-[550px] w-full z-0"></div>
            
            <!-- Loading Overlay -->
            <div id="loadingOverlay" class="absolute top-6 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur-md px-6 py-3 rounded-full shadow-lg border border-gray-100 z-10 flex items-center gap-3">
                <i data-lucide="loader-2" class="h-5 w-5 text-primary animate-spin"></i>
                <span class="font-medium text-foreground text-sm">Mendeteksi lokasi kamu...</span>
            </div>
        </div>
    </div>

    <!-- Info Panel -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Lokasi Kamu -->
        <div class="rounded-[2rem] border border-border bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="crosshair" class="h-6 w-6 text-primary"></i>
            </div>
            <h3 class="font-bold font-heading text-foreground text-lg mb-1">Lokasi Kamu</h3>
            <p id="userCoords" class="text-muted-foreground text-sm font-medium">Mendeteksi...</p>
        </div>

        <!-- Wisata Terdekat -->
        <div class="rounded-[2rem] border border-border bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="mountain-snow" class="h-6 w-6 text-accent"></i>
            </div>
            <h3 class="font-bold font-heading text-foreground text-lg mb-1">Wisata Terdekat</h3>
            <p id="nearestWisata" class="text-muted-foreground text-sm font-medium">Mendeteksi...</p>
        </div>

        <!-- Jarak Terdekat -->
        <div class="rounded-[2rem] border border-border bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="route" class="h-6 w-6 text-blue-600"></i>
            </div>
            <h3 class="font-bold font-heading text-foreground text-lg mb-1">Jarak Terdekat</h3>
            <p id="nearestDistance" class="text-muted-foreground text-sm font-medium">Menghitung...</p>
        </div>

    </div>

    <!-- Daftar Wisata Terdekat -->
    <div class="rounded-[2rem] border border-border bg-white shadow-sm overflow-hidden mb-8">
        <div class="p-6 md:p-8 border-b border-border bg-gray-50/50 flex items-center gap-3">
            <i data-lucide="list-ordered" class="h-6 w-6 text-accent"></i>
            <h2 class="text-xl font-bold font-heading m-0">Destinasi Wisata Terdekat</h2>
        </div>
        
        <div class="p-6 md:p-8">
            <div id="wisataList" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Loading State -->
                <div class="col-span-full text-center text-muted-foreground py-8 flex flex-col items-center justify-center">
                    <i data-lucide="loader-2" class="h-8 w-8 text-primary animate-spin mb-3"></i>
                    <p class="font-medium">Menghitung jarak ke destinasi...</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hitung jarak (Haversine formula)
    function hitungJarak(lat1, lng1, lat2, lng2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLng/2) * Math.sin(dLng/2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    // Init Map
    const map = L.map('map').setView([-2.5489, 118.0149], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ' OpenStreetMap contributors'
    }).addTo(map);

    // Custom Icons (Using SVG strings for Leaflet compatibility since Lucide needs DOM elements)
    const redIconHtml = `<div style="color: #F59E0B; width: 32px; height: 32px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3" fill="white"/></svg>
    </div>`;
    const redIcon = L.divIcon({ html: redIconHtml, className: '', iconSize: [32, 32], iconAnchor: [16, 32] });

    const userIconHtml = `<div style="color: #0F766E; width: 24px; height: 24px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-navigation"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
    </div>`;
    const userIcon = L.divIcon({ html: userIconHtml, className: '', iconSize: [24, 24], iconAnchor: [12, 12] });

    // Deteksi lokasi user
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                document.getElementById('loadingOverlay').style.display = 'none';
                document.getElementById('userCoords').textContent = `${userLat.toFixed(4)}, ${userLng.toFixed(4)}`;

                // Marker user
                L.marker([userLat, userLng], { icon: userIcon })
                    .addTo(map)
                    .bindPopup('<strong style="color: #0F766E; font-family: Inter, sans-serif;">Lokasi Kamu</strong>')
                    .openPopup();

                map.setView([userLat, userLng], 9);

                // Mengambil destinasi terdekat dari API dengan radius 75km
                axios.post('/api/rekomendasi-wisata', {
                    latitude: userLat,
                    longitude: userLng,
                    radius: 75000 // 75km
                })
                .then(function(response) {
                    const tempatWisata = response.data.data;
                    if(!tempatWisata || tempatWisata.length === 0) {
                        document.getElementById('wisataList').innerHTML = `<div class="col-span-full text-center text-muted-foreground py-10">Belum ada destinasi ditemukan dalam radius 75km.</div>`;
                        return;
                    }

                    const destinasiDiformat = [];
                    tempatWisata.forEach(tempat => {
                        if(tempat.tags && tempat.tags.name && tempat.lat && tempat.lon) {
                            destinasiDiformat.push({
                                nama: tempat.tags.name,
                                lat: tempat.lat,
                                lng: tempat.lon,
                                lokasi: "Destinasi terdekat dari kamu",
                                kategori: tempat.tags.tourism ? (tempat.tags.tourism.charAt(0).toUpperCase() + tempat.tags.tourism.slice(1)) : "Wisata"
                            });
                        }
                    });

                    // Hitung jarak ke semua destinasi dan urutkan
                    const withDistance = destinasiDiformat.map(d => ({
                        ...d,
                        jarak: hitungJarak(userLat, userLng, d.lat, d.lng)
                    })).sort((a, b) => a.jarak - b.jarak);

                    // Marker semua destinasi
                    withDistance.forEach(d => {
                        L.marker([d.lat, d.lng], { icon: redIcon })
                            .addTo(map)
                            .bindPopup(`<strong style="font-family: Inter, sans-serif;">${d.nama}</strong><br><span style="color: #64748b; font-family: Inter, sans-serif;">${d.lokasi}</span>`);
                    });

                    if(withDistance.length > 0) {
                        // Update info panel
                        document.getElementById('nearestWisata').textContent = withDistance[0].nama;
                        document.getElementById('nearestDistance').textContent =
                            withDistance[0].jarak < 1
                                ? `${(withDistance[0].jarak * 1000).toFixed(0)} meter`
                                : `${withDistance[0].jarak.toFixed(1)} km`;

                        // Render daftar wisata
                        const listEl = document.getElementById('wisataList');
                        listEl.innerHTML = withDistance.slice(0, 10).map((d, i) => `
                            <div class="group flex flex-col sm:flex-row items-center gap-5 p-5 rounded-[1.5rem] bg-white border border-gray-100 hover:border-primary/30 hover:shadow-md transition-all duration-300 h-full w-full relative overflow-hidden">
                                
                                <!-- Peringkat / Jarak Icon -->
                                <div class="w-14 h-14 shrink-0 rounded-2xl flex items-center justify-center font-bold text-xl ${i === 0 ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-orange-50 text-accent group-hover:scale-110 transition-transform'}">
                                    ${i + 1}
                                </div>
                                
                                <!-- Info -->
                                <div class="flex-grow text-center sm:text-left">
                                    <h4 class="font-bold text-foreground text-lg mb-1">${d.nama}</h4>
                                    <p class="text-muted-foreground text-sm flex items-center justify-center sm:justify-start gap-1">
                                        <i data-lucide="map-pin" class="h-3.5 w-3.5 opacity-70"></i> ${d.lokasi}
                                    </p>
                                </div>

                                <!-- Jarak & Kategori -->
                                <div class="sm:text-right shrink-0 mt-3 sm:mt-0 pt-3 sm:pt-0 border-t sm:border-t-0 sm:border-l border-gray-100 sm:pl-5 w-full sm:w-auto text-center">
                                    <div class="font-bold text-xl text-foreground mb-1">
                                        ${d.jarak < 1 ? (d.jarak * 1000).toFixed(0) + '<span class="text-sm font-medium text-muted-foreground ml-1">m</span>' : d.jarak.toFixed(1) + '<span class="text-sm font-medium text-muted-foreground ml-1">km</span>'}
                                    </div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-gray-50 border border-gray-200 text-xs font-medium text-muted-foreground">
                                        ${d.kategori}
                                    </span>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        document.getElementById('nearestWisata').textContent = "-";
                        document.getElementById('nearestDistance').textContent = "-";
                        document.getElementById('wisataList').innerHTML = `<div class="col-span-full text-center text-muted-foreground py-10">Data tidak ditemukan.</div>`;
                    }

                    if (window.lucide) { window.lucide.createIcons(); }
                })
                .catch(function(error) {
                    console.error("Gagal mengambil data dari API: ", error);
                    document.getElementById('wisataList').innerHTML = `<div class="col-span-full text-center text-red-500 py-10">Gagal mengambil data destinasi terdekat.</div>`;
                });
            },
            error => {
                document.getElementById('loadingOverlay').style.display = 'none';
                document.getElementById('userCoords').textContent = 'Izin lokasi ditolak';
                document.getElementById('nearestWisata').textContent = '-';
                document.getElementById('nearestDistance').textContent = '-';
                document.getElementById('wisataList').innerHTML = `
                    <div class="col-span-full text-center text-muted-foreground py-10 flex flex-col items-center">
                        <i data-lucide="map-pin-off" class="h-12 w-12 text-gray-300 mb-4"></i>
                        <p class="font-medium text-lg">Akses Lokasi Diperlukan</p>
                        <p class="text-sm">Silakan izinkan akses lokasi di browser kamu untuk melihat wisata terdekat.</p>
                    </div>
                `;
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }
        );
    } else {
        document.getElementById('loadingOverlay').style.display = 'none';
        document.getElementById('userCoords').textContent = 'Tidak didukung';
    }
});
</script>
@endsection
