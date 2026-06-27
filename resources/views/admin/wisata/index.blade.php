@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold"><i class="fa-solid fa-mountain-sun text-danger me-2"></i>Kelola Wisata</h3>
            <p class="text-muted mb-0">Daftar destinasi wisata yang tersedia</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger rounded-3">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Wisata</th>
                            <th>Lokasi</th>
                            <th>Kategori</th>
                            <th>Koordinat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wisata as $index => $w)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $w['nama'] }}</td>
                                <td><small class="text-muted">{{ $w['lokasi'] }}</small></td>
                                <td>
                                    <span class="badge rounded-pill px-3" style="background:#fff0f0; color:#e63946;">
                                        {{ $w['kategori'] }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $w['lat'] }}, {{ $w['lng'] }}</small></td>
                                <td>
                                    <span class="badge rounded-pill px-3 {{ $w['status'] === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($w['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data wisata</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
