@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto px-4 py-8 md:py-12">

    @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-teal-50 border border-teal-100 flex items-center text-primary animate-[fadeIn_0.5s_ease-out]">
            <i data-lucide="check-circle-2" class="w-5 h-5 mr-3"></i>
            <span class="font-medium">{{ session('success') }}</span>
            <button type="button" class="ml-auto text-primary hover:text-teal-800" onclick="this.parentElement.style.display='none'">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Form Section -->
        <div class="w-full lg:w-5/12">
            <div class="rounded-[2rem] border border-border bg-white p-6 lg:p-8 shadow-sm sticky top-28">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center text-accent">
                        <i data-lucide="pen-square" class="w-5 h-5"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 font-heading">Tulis Review</h2>
                </div>

                <form action="{{ route('review.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Destinasi -->
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Destinasi <span class="text-accent">*</span></label>
                        <input type="text" name="wisata_nama" 
                            class="w-full rounded-xl bg-gray-50 border border-gray-100 px-4 py-3.5 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('wisata_nama') border-red-500 @enderror"
                            placeholder="cth: Candi Borobudur" value="{{ old('wisata_nama') }}">
                        @error('wisata_nama')
                            <p class="text-red-500 text-sm mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="wisata_lokasi" 
                            class="w-full rounded-xl bg-gray-50 border border-gray-100 px-4 py-3.5 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                            placeholder="cth: Magelang, Jawa Tengah" value="{{ old('wisata_lokasi') }}">
                    </div>

                    <!-- Rating -->
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Rating <span class="text-accent">*</span></label>
                        <div class="star-rating flex flex-row-reverse justify-end gap-1">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="hidden peer" {{ old('rating') == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-accent hover:text-accent peer-hover:text-accent transition-colors text-3xl">★</label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Komentar -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Komentar <span class="text-accent">*</span></label>
                        <textarea name="komentar" rows="4" 
                            class="w-full rounded-xl bg-gray-50 border border-gray-100 px-4 py-3.5 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none @error('komentar') border-red-500 @enderror"
                            placeholder="Ceritakan pengalamanmu yang tak terlupakan...">{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <p class="text-red-500 text-sm mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-primary px-8 py-3.5 text-sm font-bold text-white shadow-md hover:bg-teal-800 transition-all active:scale-95 border-0 group">
                        <i data-lucide="send" class="w-4 h-4 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1"></i>
                        Kirim Review
                    </button>
                </form>
            </div>
        </div>

        <!-- Reviews List Section -->
        <div class="w-full lg:w-7/12">
            <div class="flex items-center gap-3 mb-6 px-2">
                <h2 class="text-2xl font-bold text-slate-900 font-heading">Review Wisatawan <span class="text-primary bg-teal-50 px-3 py-1 rounded-full text-lg ml-2">{{ $reviews->count() }}</span></h2>
            </div>

            @forelse($reviews as $review)
                <div class="rounded-[1.5rem] border border-border bg-white p-6 md:p-8 shadow-sm mb-5 transition-all hover:shadow-md">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=0F766E&color=fff&size=56"
                                class="rounded-full shadow-sm w-12 h-12 md:w-14 md:h-14 border-2 border-white ring-1 ring-gray-100" alt="{{ $review->user->name }}">
                            <div>
                                <h4 class="font-bold text-slate-900 text-base md:text-lg">{{ $review->user->name }}</h4>
                                <span class="text-sm text-slate-500 font-medium">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        <!-- Star Display -->
                        <div class="flex text-accent text-sm md:text-base">
                            @for($i = 1; $i <= 5; $i++)
                                {!! $i <= $review->rating ? '★' : '<span class="text-gray-200">★</span>' !!}
                            @endfor
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-amber-50 text-amber-700 font-semibold rounded-full text-xs md:text-sm border border-amber-100">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $review->wisata_nama }}
                        </span>
                        @if($review->wisata_lokasi)
                            <span class="inline-flex items-center gap-1 text-slate-500 text-xs md:text-sm font-medium ml-1">
                                <i data-lucide="navigation" class="w-3.5 h-3.5"></i> {{ $review->wisata_lokasi }}
                            </span>
                        @endif
                    </div>

                    <p class="text-slate-600 leading-relaxed mb-5">
                        {{ $review->komentar }}
                    </p>

                    @if($review->user_id === Auth::id())
                        <div class="pt-4 border-t border-gray-100 flex justify-end">
                            <form action="{{ route('review.destroy', $review->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-red-500 bg-red-50 hover:bg-red-100 rounded-xl transition-colors"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <!-- Empty State -->
                <div class="rounded-[2rem] border border-dashed border-gray-300 bg-gray-50/50 p-12 text-center mt-4">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mx-auto">
                            <i data-lucide="map" class="w-10 h-10 text-primary"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center rotate-12 shadow-sm">
                            <i data-lucide="star" class="w-5 h-5 text-accent fill-accent"></i>
                        </div>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-900 mb-2 font-heading">Jelajahi & Bagikan Ceritamu!</h3>
                    <p class="text-slate-500 max-w-md mx-auto">
                        Belum ada review dari wisatawan. Jadilah penjelajah pertama yang membagikan pengalaman menakjubkanmu dan menginspirasi traveler lainnya!
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Simplified CSS for star rating logic using pure CSS flex-reverse */
.star-rating > label:hover,
.star-rating > label:hover ~ label {
    color: #F59E0B; /* Tailwind accent */
}
</style>
@endsection
