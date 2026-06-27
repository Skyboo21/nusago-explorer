@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">?? Peta Wisata Real Time</h2>
        <p class="text-muted">Temukan destinasi wisata terdekat dari lokasi kamu</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0 position-relative">
            <div id="map" style="height: 500px; width: 100%;"></div>

            {{-- Loading Overlay --}}
            <div id="loadingOverlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                style="background: rgba(255,255,255,0.85); z-index: 999;">
                <div class="text-center">
                    <div class="spinner-border text-danger mb-3" role="status"></div>
                    <p class="fw-semibold text-danger">Mendeteksi lokasi kamu...</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Panel --}}
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <i class="fa-solid fa-location-crosshairs text-danger fs-3 mb-2"></i>
                <div class="fw-bold">Lokasi Kamu</div>
                <small id="userCoords" class="text-muted">Mendeteksi...</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <i class="fa-solid fa-mountain-sun text-danger fs-3 mb-2"></i>
                <div class="fw-bold">Wisata Terdekat</div>
                <small id="nearestWisata" class="text-muted">Mendeteksi...</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <i class="fa-solid fa-route text-danger fs-3 mb-2"></i>
                <div class="fw-bold">Jarak Terdekat</div>
                <small id="nearestDistance" class="text-muted">Menghitung...</small>
            </div>
        </div>
    </div>

    {{-- Daftar Wisata Terdekat --}}
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-list text-danger me-2"></i>Destinasi Wisata Terdekat</h6>
            <div id="wisataList" class="row g-3">
                <div class="text-center text-muted py-3">
                    <div class="spinner-border spinner-border-sm text-danger me-2"></div>
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
    html: '<i class="fa-solid fa-location-dot" style="color:#e63946; font-size:24px;"></i>',
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
                .bindPopup('<strong>?? Lokasi Kamu</strong>')
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
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#f8f9fa;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:40px; height:40px; background:${i === 0 ? '#e63946' : '#fff0f0'};">
                            <span class="fw-bold ${i === 0 ? 'text-white' : 'text-danger'}">${i + 1}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">${d.nama}</div>
                            <small class="text-muted">${d.lokasi}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-danger">${d.jarak < 1 ? (d.jarak * 1000).toFixed(0) + ' m' : d.jarak.toFixed(1) + ' km'}</div>
                            <small class="text-muted">${d.kategori}</small>
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
