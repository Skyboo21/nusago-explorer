@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h3 class="fw-bold"><i class="fa-solid fa-shield-halved text-danger me-2"></i>Admin Dashboard</h3>
        <p class="text-muted">Selamat datang di panel admin Nusago Explorer</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left: 4px solid #e63946 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted">Total Pengunjung</small>
                        <h2 class="fw-bold text-danger mb-0">{{ $totalPengunjung }}</h2>
                    </div>
                    <i class="fa-solid fa-users fa-2x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left: 4px solid #e63946 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted">Total Review</small>
                        <h2 class="fw-bold text-danger mb-0">{{ $totalReview }}</h2>
                    </div>
                    <i class="fa-solid fa-star fa-2x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left: 4px solid #e63946 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted">Total Guide</small>
                        <h2 class="fw-bold text-danger mb-0">{{ $totalGuide }}</h2>
                    </div>
                    <i class="fa-solid fa-person-walking-luggage fa-2x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-users text-danger me-2"></i>Pengunjung Terbaru</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengunjungBaru as $p)
                                    <tr>
                                        <td>
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->name) }}&background=e3342f&color=fff&size=30"
                                                class="rounded-circle me-2" width="30" height="30">
                                            {{ $p->name }}
                                        </td>
                                        <td><small>{{ $p->email }}</small></td>
                                        <td><small>{{ $p->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">Belum ada pengunjung</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-bolt text-danger me-2"></i>Menu Admin</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('admin.pengunjung.index') }}" class="d-flex flex-column align-items-center p-3 rounded-3 text-decoration-none text-dark" style="background:#fff0f0;">
                                <i class="fa-solid fa-users text-danger fs-4 mb-2"></i>
                                <span class="fw-semibold small">Kelola Pengunjung</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.wisata.index') }}" class="d-flex flex-column align-items-center p-3 rounded-3 text-decoration-none text-dark" style="background:#fff0f0;">
                                <i class="fa-solid fa-mountain-sun text-danger fs-4 mb-2"></i>
                                <span class="fw-semibold small">Kelola Wisata</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.guide.index') }}" class="d-flex flex-column align-items-center p-3 rounded-3 text-decoration-none text-dark" style="background:#fff0f0;">
                                <i class="fa-solid fa-person-walking-luggage text-danger fs-4 mb-2"></i>
                                <span class="fw-semibold small">Database Guide</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('review.index') }}" class="d-flex flex-column align-items-center p-3 rounded-3 text-decoration-none text-dark" style="background:#fff0f0;">
                                <i class="fa-solid fa-star text-danger fs-4 mb-2"></i>
                                <span class="fw-semibold small">Lihat Review</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
