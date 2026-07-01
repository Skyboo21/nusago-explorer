@extends('layouts.app')

@section('content')
<style>
    .text-gradient {
        background: linear-gradient(135deg, #0F766E, #F59E0B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div class="container max-w-7xl mx-auto px-4 py-12 md:py-16">
    <div class="mb-12">
        <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-muted-foreground hover:text-primary transition-colors mb-4 no-underline">
            <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i> Kembali ke Beranda
        </a>
        <h1 class="text-3xl md:text-4xl font-bold font-heading">
            Hasil Pencarian untuk <span class="text-gradient">"{{ $query ?: 'Semua' }}"</span>
        </h1>
        <p class="text-muted-foreground mt-2 text-lg">
            Kategori: 
            <span class="font-semibold text-foreground">
                @if($kategori == 'wisata') Destinasi Wisata
                @elseif($kategori == 'kuliner') Rekomendasi Kuliner
                @elseif($kategori == 'pemandu') Pemandu Lokal
                @else Semua Kategori
                @endif
            </span>
        </p>
    </div>

    @if($wisatas->isEmpty() && $kuliners->isEmpty() && $guides->isEmpty())
        <div class="text-center py-20 border border-border rounded-[2rem] bg-gray-50/50">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 text-slate-400 mb-6">
                <i data-lucide="search-x" class="h-10 w-10"></i>
            </div>
            <h2 class="text-2xl font-bold font-heading mb-2">Oops, tidak ditemukan!</h2>
            <p class="text-muted-foreground max-w-md mx-auto">
                Kami tidak dapat menemukan destinasi, kuliner, atau pemandu yang cocok dengan pencarian "{{ $query }}". Coba gunakan kata kunci lain.
            </p>
        </div>
    @else
        <div class="space-y-16">
            
            <!-- Hasil Wisata -->
            @if($wisatas->isNotEmpty())
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-primary flex items-center justify-center">
                        <i data-lucide="mountain-snow" class="h-5 w-5"></i>
                    </div>
                    <h2 class="text-2xl font-bold font-heading m-0">Destinasi Wisata</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($wisatas as $w)
                    <div class="group relative overflow-hidden rounded-[1.5rem] bg-white border border-border shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full cursor-pointer" onclick="window.location.href='/detail-wisata?nama={{ urlencode($w->nama_wisata) }}'">
                        <div class="h-48 bg-muted overflow-hidden relative">
                            <img src="{{ $w->gambar ? (filter_var($w->gambar, FILTER_VALIDATE_URL) ? $w->gambar : asset('storage/' . $w->gambar)) : 'https://images.unsplash.com/photo-1542898717-3bf7918d2eb4?auto=format&fit=crop&w=400&q=80' }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                 alt="{{ $w->nama_wisata }}">
                            @if($w->rating)
                            <div class="absolute top-3 right-3 z-20">
                                <span class="inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-2.5 py-1 text-xs font-bold text-amber-500 shadow-sm">
                                    <i data-lucide="star" class="mr-1 h-3 w-3 fill-amber-500"></i> {{ $w->rating }}
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h5 class="font-bold font-heading text-lg text-foreground truncate group-hover:text-primary transition-colors">{{ $w->nama_wisata }}</h5>
                            <p class="text-sm font-medium text-slate-500 flex items-center mt-1 mb-3">
                                <i data-lucide="map-pin" class="mr-1 h-3.5 w-3.5"></i> {{ $w->lokasi }}
                            </p>
                            <p class="text-sm text-muted-foreground line-clamp-2 flex-1">{{ $w->deskripsi }}</p>
                            
                            <div class="mt-4 flex items-center justify-between border-t border-border pt-4">
                                <span class="text-sm font-semibold text-primary">Lihat Detail</span>
                                <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Hasil Kuliner -->
            @if($kuliners->isNotEmpty())
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-accent flex items-center justify-center">
                        <i data-lucide="utensils-crossed" class="h-5 w-5"></i>
                    </div>
                    <h2 class="text-2xl font-bold font-heading m-0">Rekomendasi Kuliner</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kuliners as $k)
                    <div class="group relative overflow-hidden rounded-[1.5rem] bg-white border border-border shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full cursor-pointer" onclick="window.location.href='/kuliner'">
                        <div class="h-48 bg-muted overflow-hidden relative">
                            <img src="{{ $k->gambar_kuliner ? (filter_var($k->gambar_kuliner, FILTER_VALIDATE_URL) ? $k->gambar_kuliner : asset('storage/' . $k->gambar_kuliner)) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80' }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                 alt="{{ $k->nama_kuliner }}">
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h5 class="font-bold font-heading text-lg text-foreground truncate group-hover:text-accent transition-colors">{{ $k->nama_kuliner }}</h5>
                            <p class="text-sm font-medium text-slate-500 flex items-center mt-1 mb-3">
                                <i data-lucide="map-pin" class="mr-1 h-3.5 w-3.5"></i> {{ $k->daerah }}
                            </p>
                            <p class="text-sm text-muted-foreground line-clamp-2 flex-1">{{ $k->deskripsi_kuliner }}</p>
                            
                            <div class="mt-4 flex items-center justify-between border-t border-border pt-4">
                                <span class="text-xs font-bold text-slate-400 uppercase">{{ str_replace('_', ' ', $k->kategori) }}</span>
                                <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-colors">
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Hasil Pemandu -->
            @if($guides->isNotEmpty())
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i data-lucide="users" class="h-5 w-5"></i>
                    </div>
                    <h2 class="text-2xl font-bold font-heading m-0">Pemandu Lokal</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($guides as $g)
                    <div class="group relative overflow-hidden rounded-[1.5rem] bg-white border border-border shadow-sm hover:shadow-xl transition-all duration-300 flex items-center p-5">
                        <div class="w-16 h-16 rounded-full bg-slate-100 overflow-hidden shrink-0 mr-4 border border-border">
                            <img src="{{ $g->foto ? asset('storage/' . $g->foto) : 'https://ui-avatars.com/api/?name='.urlencode($g->nama).'&background=random' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-foreground truncate mb-0.5">{{ $g->nama }}</h5>
                            <p class="text-sm text-primary font-medium truncate mb-1">{{ $g->spesialisasi }}</p>
                            <p class="text-xs text-muted-foreground truncate"><i data-lucide="languages" class="inline h-3 w-3 mr-1"></i> {{ $g->bahasa }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

        </div>
    @endif
</div>
@endsection
