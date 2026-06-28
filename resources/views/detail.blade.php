@extends('layouts.app')

@section('content')
<div class="container my-5">
    @if($dataWisata)
        <div class="row">
            <div class="col-md-6">
                @php
                    if (Str::startsWith($dataWisata->gambar, 'http') || Str::startsWith($dataWisata->gambar, 'data:')) {
                        $imgSrc = $dataWisata->gambar;
                    } else {
                        $imgSrc = asset('img/' . $dataWisata->gambar);
                    }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $dataWisata->nama_wisata }}" class="img-fluid rounded-4 shadow-sm w-100" style="object-fit: cover; max-height: 400px;">
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h1 class="fw-bold mb-0" style="color: #1d3557;">{{ $dataWisata->nama_wisata }}</h1>
                    <span class="badge bg-warning text-dark fs-5"><i class="fa-solid fa-star text-white"></i> {{ $dataWisata->rating ?? 'N/A' }}</span>
                </div>
                <p class="text-muted fs-5"><i class="fa-solid fa-location-dot text-danger me-2"></i>{{ $dataWisata->alamat ?? $dataWisata->lokasi }}</p>
                
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($dataWisata->nama_wisata . ' ' . $dataWisata->lokasi) }}" target="_blank" class="btn btn-outline-danger mb-4 rounded-pill fw-bold shadow-sm">
                    <i class="fa-solid fa-map-location-dot me-2"></i>Lihat di Google Maps
                </a>

                <hr>
                <h4 class="fw-bold" style="color: #1d3557;">Deskripsi</h4>
                <p style="line-height: 1.8; color: #495057;">{{ $dataWisata->deskripsi }}</p>
                
                <h4 class="fw-bold mt-5 mb-3" style="color: #1d3557;">Ulasan Pengunjung</h4>
                @php
                    $reviews = \App\Models\Review::where('wisata_nama', 'LIKE', '%' . $dataWisata->nama_wisata . '%')->with('user')->get();
                @endphp

                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="card mb-3 border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1"><i class="fa-solid fa-circle-user text-secondary me-2"></i>{{ $review->user->name ?? 'Anonim' }}</h6>
                                    <span class="text-warning"><i class="fa-solid fa-star"></i> {{ $review->rating }}/5</span>
                                </div>
                                <p class="text-muted small mb-0 mt-2">"{{ $review->komentar }}"</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card mb-3 border-0 shadow-sm rounded-4 bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-1"><i class="fa-solid fa-circle-user text-secondary me-2"></i>Budi Santoso</h6>
                                <span class="text-warning"><i class="fa-solid fa-star"></i> 5/5</span>
                            </div>
                            <p class="text-muted small mb-0 mt-2">"Tempat yang sangat indah dan wajib dikunjungi! Akses ke sini juga sudah cukup bagus dan pemandangannya luar biasa."</p>
                        </div>
                    </div>
                    <div class="card mb-3 border-0 shadow-sm rounded-4 bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-1"><i class="fa-solid fa-circle-user text-secondary me-2"></i>Siti Aminah</h6>
                                <span class="text-warning"><i class="fa-solid fa-star"></i> 4/5</span>
                            </div>
                            <p class="text-muted small mb-0 mt-2">"Pemandangannya indah sekali, cocok untuk liburan keluarga. Sayangnya saat liburan agak terlalu ramai."</p>
                        </div>
                    </div>
                @endif
                
                <a href="{{ route('destinasi') }}" class="btn btn-secondary mt-4 rounded-pill px-4">Kembali</a>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h1 class="fw-bold text-muted">{{ $namaDariApi }}</h1>
            <img src="{{ asset('img/placeholder.jpg') }}" alt="Belum ada gambar" class="img-fluid rounded shadow my-3" style="max-height: 300px;">
            <p>Maaf, detail dan gambar untuk tempat wisata ini belum tersedia di database kami.</p>
            <a href="/" class="btn btn-outline-secondary mt-3">Kembali</a>
        </div>
    @endif
</div>
@endsection