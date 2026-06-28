@extends('layouts.app')

@section('content')
<style>
    .text-accent { color: #F59E0B !important; }
    .bg-accent { background-color: #F59E0B !important; }
    .bg-accent-subtle { background-color: #FEF3C7 !important; }
    .floating-notification {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 10px 24px;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .summary-icon-box { width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; margin: 0 auto 16px auto; }
    .bg-teal-subtle { background-color: #F0FDF4 !important; color: #0F766E !important; }
    .bg-amber-subtle { background-color: #FFFBEB !important; color: #F59E0B !important; }
    .bg-navy-subtle { background-color: #F8FAFC !important; color: #1E293B !important; }
    .map-container { border: 8px solid white; box-shadow: 0 20px 40px rgba(0,0,0,0.06); border-radius: 24px !important; }
</style>
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark mb-3">Peta Wisata Real Time</h2>
        <p class="text-secondary fs-5">Temukan destinasi wisata terdekat dari lokasi kamu</p>
    </div>

    <div class="card border-0 map-container overflow-hidden mb-5">
        <div class="card-body p-0 position-relative">
            <div id="map" style="height: 550px; width: 100%;"></div>

            {{-- Loading Overlay --}}
            <div id="loadingOverlay" class="floating-notification">
                <div class="spinner-border spinner-border-sm" style="color: #0F766E;" role="status"></div>
                <span class="fw-semibold text-dark mb-0">Mendeteksi lokasi kamu...</span>
            </div>
        </div>
    </div>

    {{-- Info Panel --}}
    <div class="row g-4 mt-2 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center hover-lift h-100">
                <div class="summary-icon-box bg-teal-subtle">
                    <i class="fa-solid fa-location-crosshairs fs-4"></i>
                </div>
                <div class="fw-bold text-dark fs-5 mb-1">Lokasi Kamu</div>
                <small id="userCoords" class="text-secondary fw-medium">Mendeteksi...</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center hover-lift h-100">
                <div class="summary-icon-box bg-amber-subtle">
                    <i class="fa-solid fa-mountain-sun fs-4"></i>
                </div>
                <div class="fw-bold text-dark fs-5 mb-1">Wisata Terdekat</div>
                <small id="nearestWisata" class="text-secondary fw-medium">Mendeteksi...</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center hover-lift h-100">
                <div class="summary-icon-box bg-navy-subtle">
                    <i class="fa-solid fa-route fs-4"></i>
                </div>
                <div class="fw-bold text-dark fs-5 mb-1">Jarak Terdekat</div>
                <small id="nearestDistance" class="text-secondary fw-medium">Menghitung...</small>
            </div>
        </div>
    </div>

    {{-- Daftar Wisata Terdekat --}}
    <div class="card border-0 shadow-sm rounded-4 mt-4 overflow-hidden">
        <div class="card-header bg-white border-bottom p-4">
            <h5 class="fw-bold mb-0" style="color: #0F766E;"><i class="fa-solid fa-list text-accent me-2"></i>Destinasi Wisata Terdekat</h5>
        </div>
        <div class="card-body p-4 bg-light">
            <div id="wisataList" class="row g-4">
                <div class="text-center text-muted py-4">
                    <div class="spinner-border spinner-border-sm text-accent me-2"></div>
                    Menghitung jarak...
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const destinasi = [
    { nama: "Taman Nasional Komodo", lat: -8.5435, lng: 119.4231, lokasi: "Kabupaten Manggarai Barat, NTT", kategori: "Alam" },
    { nama: "Raja Ampat", lat: -0.2333, lng: 130.5167, lokasi: "Kabupaten Raja Ampat, Papua Barat Daya", kategori: "Alam" },
    { nama: "Wae Rebo", lat: -8.7695, lng: 120.2828, lokasi: "Manggarai, NTT", kategori: "Budaya" },
    { nama: "Candi Borobudur", lat: -7.6079, lng: 110.2038, lokasi: "Magelang, Jawa Tengah", kategori: "Sejarah" },
    { nama: "Nusa Penida", lat: -8.7278, lng: 115.5444, lokasi: "Klungkung, Bali", kategori: "Alam" },
    { nama: "Gunung Bromo", lat: -7.9425, lng: 112.9530, lokasi: "Jawa Timur", kategori: "Alam" }
];

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

// Icon custom merah
const redIcon = L.divIcon({
    html: '<i class="fa-solid fa-location-dot" style="color:#F59E0B; font-size:24px;"></i>',
    className: '',
    iconSize: [24, 24],
    iconAnchor: [12, 24],
});

const userIcon = L.divIcon({
    html: '<i class="fa-solid fa-circle-dot" style="color:#1d3557; font-size:20px;"></i>',
    className: '',
    iconSize: [20, 20],
    iconAnchor: [10, 10],
});



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
                .bindPopup('<strong style="color: #0F766E;">Lokasi Kamu</strong>')
                .openPopup();

            map.setView([userLat, userLng], 8);

            // Hitung jarak ke semua destinasi
            const withDistance = destinasi.map(d => ({
                ...d,
                jarak: hitungJarak(userLat, userLng, d.lat, d.lng)
            })).sort((a, b) => a.jarak - b.jarak);

            // Update info panel
            document.getElementById('nearestWisata').textContent = withDistance[0].nama;
            document.getElementById('nearestDistance').textContent =
                withDistance[0].jarak < 1
                    ? `${(withDistance[0].jarak * 1000).toFixed(0)} meter`
                    : `${withDistance[0].jarak.toFixed(1)} km`;

            // Render daftar wisata
            const listEl = document.getElementById('wisataList');
            listEl.innerHTML = withDistance.map((d, i) => `
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-3 p-4 rounded-4 shadow-sm bg-white border hover-lift h-100" style="border-color: rgba(0,0,0,0.05) !important;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm"
                            style="width:48px; height:48px; background:${i === 0 ? '#0F766E' : '#FEF3C7'};">
                            <span class="fw-bold fs-5 ${i === 0 ? 'text-white' : 'text-accent'}">${i + 1}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark fs-5 mb-1">${d.nama}</div>
                            <small class="text-secondary"><i class="fa-solid fa-map-pin me-1 opacity-50"></i>${d.lokasi}</small>
                        </div>
                        <div class="text-end ps-3 border-start">
                            <div class="fw-bold fs-5 text-dark">${d.jarak < 1 ? (d.jarak * 1000).toFixed(0) + ' <span class="fs-6 fw-normal text-muted">m</span>' : d.jarak.toFixed(1) + ' <span class="fs-6 fw-normal text-muted">km</span>'}</div>
                            <span class="badge bg-light text-secondary border mt-1">${d.kategori}</span>
                        </div>
                    </div>
                </div>
            `).join('');
        },
        error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            document.getElementById('userCoords').textContent = 'Izin lokasi ditolak';
            document.getElementById('nearestWisata').textContent = '-';
            document.getElementById('nearestDistance').textContent = '-';
            document.getElementById('wisataList').innerHTML =
                '<div class="col-12 text-center text-muted py-3"><i class="fa-solid fa-location-slash me-2"></i>Izinkan akses lokasi untuk melihat wisata terdekat</div>';
        }
    );
} else {
    document.getElementById('loadingOverlay').style.display = 'none';
    document.getElementById('userCoords').textContent = 'Browser tidak mendukung GPS';
}
</script>
@endsection
