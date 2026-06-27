@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold"><i class="fa-solid fa-plus text-danger me-2"></i>Tambah Guide</h3>
            <p class="text-muted mb-0">Tambahkan data pemandu wisata baru</p>
        </div>
        <a href="{{ route('admin.guide.index') }}" class="btn btn-outline-danger rounded-3">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.guide.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control rounded-3 @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Nama lengkap guide">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="email@example.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="telepon" class="form-control rounded-3 @error('telepon') is-invalid @enderror"
                            value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
                        @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Bahasa <span class="text-danger">*</span></label>
                        <input type="text" name="bahasa" class="form-control rounded-3 @error('bahasa') is-invalid @enderror"
                            value="{{ old('bahasa') }}" placeholder="cth: Indonesia, Inggris">
                        @error('bahasa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" name="spesialisasi" class="form-control rounded-3 @error('spesialisasi') is-invalid @enderror"
                            value="{{ old('spesialisasi') }}" placeholder="cth: Wisata Alam, Sejarah">
                        @error('spesialisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Harga per Hari (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga_per_hari" class="form-control rounded-3 @error('harga_per_hari') is-invalid @enderror"
                            value="{{ old('harga_per_hari') }}" placeholder="cth: 500000">
                        @error('harga_per_hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control rounded-3"
                            placeholder="Deskripsi singkat tentang guide...">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select rounded-3">
                            <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn text-white px-5 rounded-3" style="background:#e63946;">
                        <i class="fa-solid fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
