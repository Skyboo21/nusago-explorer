@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header & Search -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-foreground flex items-center gap-3">
                <i data-lucide="message-square" class="h-8 w-8 text-primary"></i> Kelola Review
            </h1>
            <p class="text-muted-foreground mt-2">Moderasi ulasan dan penilaian dari pengunjung</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-primary transition-all shadow-sm text-sm font-medium text-decoration-none whitespace-nowrap">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
            
            <form action="{{ route('admin.review.index') }}" method="GET" class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary sm:text-sm transition-all" placeholder="Cari ulasan...">
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-green-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($reviews as $review)
            <div class="bg-white rounded-[2rem] shadow-sm border border-border p-6 flex flex-col h-full hover:shadow-md transition-shadow relative overflow-hidden group">
                <!-- Delete Button -->
                <form action="{{ route('admin.review.destroy', $review->id) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors shadow-sm">
                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                    </button>
                </form>

                <div class="flex items-center gap-3 mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name ?? 'Anonim') }}&background=e3342f&color=fff&size=40" class="w-10 h-10 rounded-full shadow-sm">
                    <div>
                        <p class="text-sm font-semibold text-gray-900 m-0">{{ $review->user->name ?? 'Pengguna Dihapus' }}</p>
                        <p class="text-xs text-gray-500 m-0">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 mb-2">
                        <i data-lucide="map-pin" class="h-3 w-3 text-primary"></i> {{ $review->wisata_nama }}
                    </div>
                    <div class="flex items-center gap-1 text-amber-500">
                        @for($i = 1; $i <= 5; $i++)
                            <i data-lucide="star" class="h-4 w-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}"></i>
                        @endfor
                        <span class="ml-1 text-sm font-semibold text-gray-700">{{ $review->rating }}/5</span>
                    </div>
                </div>

                <p class="text-sm text-gray-600 m-0 flex-grow italic line-clamp-4">
                    "{{ $review->komentar }}"
                </p>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-gray-500 bg-white rounded-[2rem] border border-border">
                <div class="flex flex-col items-center justify-center gap-3">
                    <i data-lucide="message-square-off" class="h-12 w-12 text-gray-300"></i>
                    <p class="m-0 text-lg font-medium text-gray-400">Tidak ada ulasan ditemukan.</p>
                    @if(request('search'))
                        <a href="{{ route('admin.review.index') }}" class="text-primary text-sm hover:underline mt-2">Hapus filter pencarian</a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
