@extends('layouts.app')

@section('content')
<style>
    .text-accent { color: #F59E0B !important; }
    .bg-accent { background-color: #F59E0B !important; }
    .bg-accent-subtle { background-color: #FEF3C7 !important; color: #92400E !important; }
    .text-teal { color: #0F766E !important; }
    .btn-accent { background-color: #F59E0B; color: white; border: none; transition: all 0.3s ease; }
    .btn-accent:hover { background-color: #d97706; color: white; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3); }
    .custom-input { background: #f8f9fa; border: 1px solid transparent; transition: all 0.3s; }
    .custom-input:focus { background: #fff; border-color: #0F766E; box-shadow: 0 0 0 0.25rem rgba(15, 118, 110, 0.15); outline: none; }
</style>
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="card border-0 shadow rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-5">
                    <h5 class="fw-bold mb-4 text-teal"><i class="fa-solid fa-pen-to-square text-accent me-2"></i>Tulis Review</h5>
                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Nama Destinasi <span class="text-accent">*</span></label>
                            <input type="text" name="wisata_nama" class="form-control custom-input px-4 py-3 rounded-4 @error('wisata_nama') is-invalid @enderror"
                                placeholder="cth: Candi Borobudur" value="{{ old('wisata_nama') }}">
                            @error('wisata_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Lokasi</label>
                            <input type="text" name="wisata_lokasi" class="form-control custom-input px-4 py-3 rounded-4"
                                placeholder="cth: Magelang, Jawa Tengah" value="{{ old('wisata_lokasi') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Rating <span class="text-accent">*</span></label>
                            <div class="star-rating d-flex gap-2">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                                        class="d-none" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="fs-4" style="cursor:pointer; color:#ccc;">&#9733;</label>
                                @endfor
                            </div>
                            @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-semibold text-secondary">Komentar <span class="text-accent">*</span></label>
                            <textarea name="komentar" rows="4" class="form-control custom-input px-4 py-3 rounded-4 @error('komentar') is-invalid @enderror"
                                placeholder="Ceritakan pengalamanmu...">{{ old('komentar') }}</textarea>
                            @error('komentar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn w-100 fw-bold text-white rounded-pill py-3 btn-accent mt-2">
                            <i class="fa-solid fa-paper-plane me-2"></i>Kirim Review
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <h5 class="fw-bold mb-4 text-teal"><i class="fa-solid fa-comments text-accent me-2"></i>Review Wisatawan ({{ $reviews->count() }})</h5>
            @forelse($reviews as $review)
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=0F766E&color=fff&size=48"
                                    class="rounded-circle shadow-sm" width="48" height="48">
                                <div>
                                    <div class="fw-bold">{{ $review->user->name }}</div>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="text-accent fs-6">
                                @for($i = 1; $i <= 5; $i++)
                                    {!! $i <= $review->rating ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>' !!}
                                @endfor
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="badge rounded-pill px-3 py-2 fw-semibold bg-accent-subtle">
                                <i class="fa-solid fa-location-dot me-1 text-accent"></i><span style="color: #495057;">{{ $review->wisata_nama }}</span>
                            </span>
                            @if($review->wisata_lokasi)
                                <small class="text-muted ms-2"><i class="fa-solid fa-map-pin me-1"></i>{{ $review->wisata_lokasi }}</small>
                            @endif
                        </div>
                        <p class="mb-2 text-secondary">{{ $review->komentar }}</p>
                        @if($review->user_id === Auth::id())
                            <form action="{{ route('review.destroy', $review->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-3"
                                    onclick="return confirm('Hapus review ini?')">
                                    <i class="fa-solid fa-trash me-1"></i>Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5 my-5">
                    <div class="position-relative d-inline-block mb-4">
                        <i class="fa-solid fa-map-location-dot" style="font-size: 5rem; color: #0F766E; opacity: 0.9;"></i>
                        <i class="fa-solid fa-star position-absolute" style="color: #F59E0B; font-size: 2.2rem; top: -15px; right: -25px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2)); transform: rotate(15deg);"></i>
                    </div>
                    <h4 class="fw-bold text-teal mb-3">Jelajahi & Bagikan Ceritamu!</h4>
                    <p class="text-muted" style="font-size: 1.1rem;">Belum ada review. Jadilah penjelajah pertama yang menginspirasi traveler lainnya.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.star-rating { flex-direction: row-reverse; justify-content: flex-end; }
.star-rating label { transition: color 0.2s; }
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label { color: #F59E0B !important; }
</style>
@endsection
