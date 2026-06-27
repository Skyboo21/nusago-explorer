@extends('layouts.app')

@section('content')
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 80px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="fa-solid fa-pen-to-square text-danger me-2"></i>Tulis Review</h5>
                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Destinasi <span class="text-danger">*</span></label>
                            <input type="text" name="wisata_nama" class="form-control rounded-3 @error('wisata_nama') is-invalid @enderror"
                                placeholder="cth: Candi Borobudur" value="{{ old('wisata_nama') }}">
                            @error('wisata_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lokasi</label>
                            <input type="text" name="wisata_lokasi" class="form-control rounded-3"
                                placeholder="cth: Magelang, Jawa Tengah" value="{{ old('wisata_lokasi') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                            <div class="star-rating d-flex gap-2">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                                        class="d-none" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="fs-4" style="cursor:pointer; color:#ccc;">&#9733;</label>
                                @endfor
                            </div>
                            @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Komentar <span class="text-danger">*</span></label>
                            <textarea name="komentar" rows="4" class="form-control rounded-3 @error('komentar') is-invalid @enderror"
                                placeholder="Ceritakan pengalamanmu...">{{ old('komentar') }}</textarea>
                            @error('komentar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn w-100 fw-bold text-white rounded-3 py-2" style="background:#e63946;">
                            <i class="fa-solid fa-paper-plane me-2"></i>Kirim Review
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-comments text-danger me-2"></i>Review Wisatawan ({{ $reviews->count() }})</h5>
            @forelse($reviews as $review)
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=e3342f&color=fff&size=40"
                                    class="rounded-circle" width="40" height="40">
                                <div>
                                    <div class="fw-bold">{{ $review->user->name }}</div>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="text-warning fs-6">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '?' : '?' }}
                                @endfor
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="badge rounded-pill px-3 py-1 fw-semibold" style="background:#fff0f0; color:#e63946;">
                                <i class="fa-solid fa-location-dot me-1"></i>{{ $review->wisata_nama }}
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
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-comment-slash fs-1 mb-3 d-block opacity-25"></i>
                    Belum ada review. Jadilah yang pertama!
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
.star-rating label:hover ~ label { color: #f1c40f !important; }
</style>
@endsection
