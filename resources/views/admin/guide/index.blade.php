@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold"><i class="fa-solid fa-person-walking-luggage text-danger me-2"></i>Database Guide</h3>
            <p class="text-muted mb-0">Kelola data pemandu wisata</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.guide.create') }}" class="btn text-white rounded-3" style="background:#e63946;">
                <i class="fa-solid fa-plus me-1"></i>Tambah Guide
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger rounded-3">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Guide</th>
                            <th>Kontak</th>
                            <th>Spesialisasi</th>
                            <th>Harga/Hari</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guides as $index => $g)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $g->nama }}</div>
                                    <small class="text-muted">{{ $g->bahasa }}</small>
                                </td>
                                <td>
                                    <small>{{ $g->email }}</small><br>
                                    <small class="text-muted">{{ $g->telepon }}</small>
                                </td>
                                <td><small>{{ $g->spesialisasi }}</small></td>
                                <td>Rp {{ number_format($g->harga_per_hari, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 {{ $g->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($g->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.guide.edit', $g->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-3">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.guide.destroy', $g->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-3"
                                                onclick="return confirm('Hapus guide ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data guide</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
