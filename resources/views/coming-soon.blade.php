@extends('layouts.app')

@section('content')
@guest
<div class="position-relative">
    <div style="filter: blur(8px); pointer-events: none; user-select: none; opacity: 0.6;">
@endguest

<div class="container py-5 text-center" style="min-height: 60vh; display: flex; flex-direction: column; justify-content: center;">

    <h1 class="fw-bold text-danger mb-4"><i class="fa-solid fa-person-digging me-3"></i>Segera Hadir!</h1>
    <h4 class="text-secondary mb-4">Fitur <strong>{{ $title }}</strong> sedang dalam tahap pengembangan.</h4>
    <p class="text-muted mb-5">Kami sedang bekerja keras untuk segera menyajikan fitur ini untuk kamu. Nantikan update terbaru dari Nusago Explorer!</p>
    <div>
        <a href="/" class="btn btn-custom"><i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Beranda</a>
    </div>
</div>

@guest
    </div>
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center" style="z-index: 10;">
        <div class="bg-white p-5 rounded-4 shadow border" style="max-width: 500px;">
            <i class="fa-solid fa-lock text-danger fa-3x mb-3"></i>
            <h3 class="fw-bold text-dark">Akses Terbatas</h3>
            <p class="text-muted mb-4">Untuk menggunakan fitur {{ $title }}, silakan login/register terlebih dahulu.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-danger px-4 rounded-pill fw-bold">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-danger px-4 rounded-pill fw-bold">Daftar</a>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection
