@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto px-4 py-8 md:py-12">
    <!-- Header -->
    <div class="mb-10 text-center animate-[fadeIn_0.5s_ease-out]">
        <h1 class="text-3xl md:text-4xl font-bold font-heading text-foreground mb-3">Eksplorasi Kamera Virtual</h1>
        <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
            Jelajahi destinasi wisata Indonesia secara virtual dengan Google Street View. Rasakan sensasi seolah berada di sana!
        </p>
    </div>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
        <button class="filter-btn px-6 py-2 rounded-full font-medium text-sm transition-all duration-300 border bg-primary text-white border-primary shadow-sm" data-filter="all" data-active="true">
            Semua
        </button>
        @foreach($kategori as $k)
            <button class="filter-btn px-6 py-2 rounded-full font-medium text-sm transition-all duration-300 border bg-white text-foreground border-gray-200 hover:bg-gray-50" data-filter="{{ $k }}" data-active="false">
                {{ $k }}
            </button>
        @endforeach
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="destinasiGrid">
        @foreach($destinasi as $d)
            <div class="destinasi-card group relative overflow-hidden rounded-[2rem] border border-border bg-white shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full" data-kategori="{{ $d['kategori'] }}">
                
                <!-- Image Container -->
                <div class="relative h-56 w-full overflow-hidden shrink-0">
                    <img src="{{ $d['foto'] }}" 
                         alt="{{ $d['nama'] }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         onerror="this.onerror=null; this.src='https://placehold.co/600x400/F0FDF4/0F766E?text={{ urlencode($d['nama']) }}'">
                    
                    <!-- Gradient Overlay for better contrast -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-80"></div>
                    
                    <!-- Kategori Badge -->
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5 border border-white/20">
                        <span class="w-2 h-2 rounded-full bg-accent"></span>
                        <span class="text-xs font-bold text-accent uppercase tracking-wider">{{ $d['kategori'] }}</span>
                    </div>

                    <!-- Floating Title on Image -->
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h3 class="text-xl font-bold font-heading mb-1 line-clamp-1">{{ $d['nama'] }}</h3>
                        <p class="text-white/80 text-sm flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="h-3.5 w-3.5"></i> <span class="line-clamp-1">{{ $d['lokasi'] }}</span>
                        </p>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-muted-foreground text-sm leading-relaxed mb-6 flex-grow">
                        {{ $d['deskripsi'] }}
                    </p>
                    
                    <!-- Action Button -->
                    <a href="{{ route('virtual-camera.show', ['nama' => $d['nama']]) }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 transition-all active:scale-95 text-decoration-none group/btn">
                        <i data-lucide="camera" class="mr-2 h-4 w-4 transition-transform group-hover/btn:scale-110"></i> Lihat Street View
                    </a>
                </div>

            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.destinasi-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Reset all buttons
            filterBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-white', 'border-primary', 'shadow-sm');
                b.classList.add('bg-white', 'text-foreground', 'border-gray-200', 'hover:bg-gray-50');
                b.setAttribute('data-active', 'false');
            });

            // Set active button
            this.classList.remove('bg-white', 'text-foreground', 'border-gray-200', 'hover:bg-gray-50');
            this.classList.add('bg-primary', 'text-white', 'border-primary', 'shadow-sm');
            this.setAttribute('data-active', 'true');

            const filter = this.dataset.filter;

            // Filter cards
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.kategori === filter) {
                    card.style.display = '';
                    // Add subtle pop animation
                    card.style.animation = 'none';
                    card.offsetHeight; // trigger reflow
                    card.style.animation = 'fadeIn 0.3s ease-out forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
