@extends('layouts.app')

@section('content')
<div class="container my-5">
    @if($dataWisata)
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('img/' . $dataWisata->gambar) }}" alt="{{ $dataWisata->nama_wisata }}" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h1 class="fw-bold">{{ $dataWisata->nama_wisata }}</h1>
                <p class="text-muted"><i class="fa-solid fa-location-dot me-2"></i>{{ $dataWisata->alamat }}</p>
                <hr>
                <h4>Deskripsi</h4>
                <p>{{ $dataWisata->deskripsi }}</p>
                
                <a href="/" class="btn btn-primary mt-3">Kembali ke Beranda</a>
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