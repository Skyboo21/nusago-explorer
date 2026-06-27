@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold"><i class="fa-solid fa-users text-danger me-2"></i>Kelola Pengunjung</h3>
            <p class="text-muted mb-0">Daftar semua pengunjung yang terdaftar</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger rounded-3">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
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
                            <th>Pengunjung</th>
                            <th>Email</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengunjung as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->name) }}&background=e3342f&color=fff&size=35"
                                            class="rounded-circle" width="35" height="35">
                                        <span class="fw-semibold">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.pengunjung.destroy', $p->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3"
                                            onclick="return confirm('Hapus pengunjung ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada pengunjung</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
