@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">?? Eksplorasi Kamera Virtual</h2>
        <p class="text-muted">Jelajahi destinasi wisata Indonesia secara virtual dengan Google Street View</p>
    </div>

    <div class="d-flex gap-2 flex-wrap justify-content-center mb-4">
        <button class="btn btn-danger rounded-pill px-4 filter-btn active" data-filter="all">Semua</button>
        @foreach($kategori as $k)
            <button class="btn btn-outline-danger rounded-pill px-4 filter-btn" data-filter="{{ $k }}">{{ $k }}</button>
        @endforeach
    </div>

    <div class="row g-4" id="destinasiGrid">
        @foreach($destinasi as $d)
            <div class="col-md-6 col-lg-4 destinasi-card" data-kategori="{{ $d['kategori'] }}">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="position-relative" style="height:200px; overflow:hidden;">
                        <img src="{{ $d['foto'] }}" class="w-100 h-100"
                            style="object-fit:cover; transition:transform 0.3s;"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'"
                            onerror="this.src='https://via.placeholder.com/400x200?text={{ urlencode($d['nama']) }}'">
                        <span class="position-absolute top-0 end-0 m-2 badge rounded-pill"
                            style="background:rgba(230,57,70,0.9);">{{ $d['kategori'] }}</span>
                    </div>
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-1">{{ $d['nama'] }}</h6>
                        <small class="text-muted d-block mb-2">
                            <i class="fa-solid fa-location-dot text-danger me-1"></i>{{ $d['lokasi'] }}
                        </small>
                        <p class="text-secondary small mb-3">{{ $d['deskripsi'] }}</p>
                        <a href="{{ route('virtual-camera.show', ['nama' => $d['nama']]) }}"
                            class="btn w-100 text-white fw-semibold rounded-3" style="background:#e63946;">
                            <i class="fa-solid fa-street-view me-2"></i>Lihat Street View
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active', 'btn-danger');
            b.classList.add('btn-outline-danger');
        });
        this.classList.add('active', 'btn-danger');
        this.classList.remove('btn-outline-danger');
        const filter = this.dataset.filter;
        document.querySelectorAll('.destinasi-card').forEach(card => {
            card.style.display = (filter === 'all' || card.dataset.kategori === filter) ? '' : 'none';
        });
    });
});
</script>
@endsection
