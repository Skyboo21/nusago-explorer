@extends('layouts.app')

@section('content')
<style>
    /* Custom Scrollbar for Carousel */
    .carousel-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
        padding-top: 1rem;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #0F766E #f1f1f1;
    }
    .carousel-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    .carousel-wrapper::-webkit-scrollbar-track {
        background: transparent; 
    }
    .carousel-wrapper::-webkit-scrollbar-thumb {
        background: #e4e4e7; 
        border-radius: 10px;
    }
    .carousel-wrapper:hover::-webkit-scrollbar-thumb {
        background: #0F766E; 
    }
    .carousel-card {
        min-width: 300px;
        scroll-snap-align: start;
        flex: 0 0 auto;
    }

    /* Gradient Text */
    .text-gradient {
        background: linear-gradient(135deg, #0F766E, #F59E0B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<!-- Hero Section (Redesigned) -->
<section class="w-full pt-12 pb-24 md:pt-16 md:pb-32 overflow-hidden">
    <div class="container max-w-7xl mx-auto px-4">
        <div class="border border-border rounded-[2rem] md:rounded-[3rem] bg-gradient-to-br from-white to-teal-50/50 p-6 md:p-12 lg:p-16 relative overflow-hidden shadow-sm">
            <!-- Background Decoration -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-primary/5 rounded-full blur-3xl"></div>

            <div class="grid gap-12 lg:grid-cols-[1.2fr_1fr] relative z-10 items-center">
                <div class="flex flex-col justify-center space-y-6">
                    <div class="space-y-4">
                        <div class="inline-flex items-center rounded-full bg-white border border-border px-4 py-1.5 text-sm font-medium text-foreground shadow-sm w-fit">
                            <i data-lucide="sparkles" class="mr-2 h-4 w-4 text-accent"></i> 
                            Platform Wisata Terintegrasi
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-heading tracking-tight leading-[1.1]">
                            Eksplorasi Tanpa Batas di <span class="text-gradient">Nusantara</span>
                        </h1>
                        <p class="max-w-[600px] text-muted-foreground md:text-xl leading-relaxed">
                            Temukan destinasi tersembunyi, cicipi kuliner otentik, dan dengarkan cerita langsung dari pemandu lokal di setiap langkah Anda.
                        </p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('destinasi') }}" class="inline-flex items-center justify-center rounded-full bg-primary px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-teal-900/20 hover:bg-teal-800 transition-all active:scale-95 group no-underline">
                            Mulai Menjelajah
                            <i data-lucide="arrow-right" class="ml-2 h-5 w-5 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        <a href="#fitur" class="inline-flex items-center justify-center rounded-full border border-border bg-white/50 backdrop-blur-sm px-8 py-3.5 text-base font-semibold text-foreground shadow-sm hover:bg-white transition-all no-underline">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <!-- Hero Images Gallery -->
                <div class="relative h-[400px] md:h-[500px] w-full hidden lg:block">
                    <!-- Main Image -->
                    <div class="absolute right-0 top-0 w-4/5 h-4/5 rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white z-20 transition-transform duration-700 hover:scale-105">
                        <img src="https://images.unsplash.com/photo-1570213489059-0aac6626cade?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Bali" class="w-full h-full object-cover" />
                    </div>
                    <!-- Small Image 1 -->
                    <div class="absolute left-0 bottom-10 w-2/3 h-2/3 rounded-[2rem] overflow-hidden shadow-xl border-4 border-white z-30 transition-transform duration-700 hover:-translate-y-4">
                        <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bromo" class="w-full h-full object-cover" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Box (Redesigned as Seamless Unified Pill) -->
<section class="container max-w-5xl mx-auto px-4 relative z-20 -mt-24 md:-mt-32 mb-16">
    <div class="bg-white/90 backdrop-blur-2xl border border-white/60 p-2 md:p-2.5 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.08)]">
        <form class="flex flex-col md:flex-row items-stretch divide-y md:divide-y-0 md:divide-x divide-gray-100">
            
            <div class="flex-1 w-full flex items-center gap-4 px-6 md:px-8 py-5 hover:bg-slate-50/50 rounded-t-[2rem] md:rounded-l-[2rem] md:rounded-tr-none transition-colors group cursor-text">
                <i data-lucide="map-pin" class="h-6 w-6 text-slate-400 group-focus-within:text-primary transition-colors"></i>
                <div class="w-full">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 block">Lokasi</label>
                    <input type="text" class="w-full border-0 p-0 text-slate-800 font-bold placeholder:text-slate-300 focus:ring-0 text-base bg-transparent outline-none" placeholder="Contoh: Bali, Solo, Bromo...">
                </div>
            </div>
            
            <div class="flex-1 w-full flex items-center gap-4 px-6 md:px-8 py-5 hover:bg-slate-50/50 transition-colors group relative cursor-pointer">
                <i data-lucide="layout-grid" class="h-6 w-6 text-slate-400 group-focus-within:text-primary transition-colors"></i>
                <div class="w-full pr-8">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 block">Kategori</label>
                    <select class="w-full border-0 p-0 text-slate-800 font-bold bg-transparent focus:ring-0 cursor-pointer appearance-none outline-none">
                        <option>Semua (Wisata, Pemandu, Kuliner)</option>
                        <option>Hanya Destinasi Wisata</option>
                        <option>Pemandu Lokal (Tour Guide)</option>
                        <option>Rekomendasi Kuliner</option>
                    </select>
                </div>
                <!-- Custom Chevron -->
                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400"></i>
                </div>
            </div>

            <div class="w-full md:w-auto p-1.5 md:pl-2">
                <button type="submit" class="w-full md:w-auto h-full min-h-[64px] inline-flex items-center justify-center rounded-full bg-accent px-10 py-4 text-lg font-bold text-white shadow-lg shadow-amber-500/30 hover:bg-amber-600 transition-all active:scale-95 border-0 outline-none" style="border: none !important; outline: none !important;">
                    <i data-lucide="search" class="mr-2 h-5 w-5"></i> Cari
                </button>
            </div>

        </form>
    </div>
</section>

<!-- === SECTION BARU: REKOMENDASI LOKASI CAROUSEL === -->
<section class="container max-w-7xl mx-auto px-4 mb-24">
    <div class="border border-border rounded-[2rem] bg-gray-50/50 p-6 md:p-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <div class="inline-flex items-center rounded-full bg-teal-50 px-3 py-1 text-sm font-medium text-primary mb-3">
                    <i data-lucide="map" class="mr-2 h-4 w-4"></i> Lokasi Anda
                </div>
                <h3 class="text-3xl font-bold font-heading m-0">Ada Apa di Sekitarmu?</h3>
            </div>
            <!-- Tombol untuk trigger permintaan lokasi -->
            <button onclick="cariWisataTerdekat()" id="btn-lokasi" class="inline-flex items-center justify-center rounded-full border border-primary bg-white px-6 py-2.5 text-sm font-semibold text-primary shadow-sm hover:bg-primary hover:text-white transition-all active:scale-95 group">
                <i data-lucide="crosshair" class="mr-2 h-4 w-4 group-hover:animate-pulse"></i> Aktifkan Lokasi
            </button>
        </div>

        <!-- Status Teks (Loading/Error) -->
        <div id="status-lokasi" class="flex items-center gap-2 text-muted-foreground bg-white border border-border p-4 rounded-2xl w-fit" style="display: none;"></div>

        <!-- Wadah Carousel -->
        <div id="carousel-rekomendasi" class="carousel-wrapper" style="display: none;">
            <!-- Hasil kartu wisata akan disuntikkan oleh Javascript di sini -->
        </div>
    </div>
</section>
<!-- ================================================= -->

<!-- Features Section (Redesigned) -->
<section id="fitur" class="container max-w-7xl mx-auto px-4 mb-24">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold font-heading relative inline-block">
            Layanan Terintegrasi Kami
            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-16 h-1.5 bg-gradient-to-r from-primary to-accent rounded-full"></div>
        </h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="group relative overflow-hidden rounded-[2rem] border border-border bg-white p-8 shadow-sm transition-all hover:shadow-xl hover:-translate-y-2 duration-300">
            <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-teal-50 group-hover:bg-teal-100 transition-all duration-300"></div>
            <div class="relative space-y-4 z-10">
                <div class="w-16 h-16 rounded-2xl bg-teal-50 text-primary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="mountain-snow" class="h-8 w-8"></i>
                </div>
                <h4 class="text-xl font-bold font-heading m-0">Destinasi Menawan</h4>
                <p class="text-muted-foreground leading-relaxed">
                    Jelajahi informasi lengkap mengenai tempat wisata di Indonesia, mulai dari harga tiket hingga rute perjalanan terbaik dengan visual yang menakjubkan.
                </p>
            </div>
        </div>
        
        <div class="group relative overflow-hidden rounded-[2rem] border border-border bg-white p-8 shadow-sm transition-all hover:shadow-xl hover:-translate-y-2 duration-300">
            <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-orange-50 group-hover:bg-orange-100 transition-all duration-300"></div>
            <div class="relative space-y-4 z-10">
                <div class="w-16 h-16 rounded-2xl bg-orange-50 text-accent flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="users" class="h-8 w-8"></i>
                </div>
                <h4 class="text-xl font-bold font-heading m-0">Pemandu Lokal</h4>
                <p class="text-muted-foreground leading-relaxed">
                    Perjalanan lebih aman dan bermakna dengan ditemani warga asli daerah yang siap menjadi Tour Guide andalanmu untuk mengungkap rahasia lokal.
                </p>
            </div>
        </div>

        <div class="group relative overflow-hidden rounded-[2rem] border border-border bg-white p-8 shadow-sm transition-all hover:shadow-xl hover:-translate-y-2 duration-300">
            <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-teal-50 group-hover:bg-teal-100 transition-all duration-300"></div>
            <div class="relative space-y-4 z-10">
                <div class="w-16 h-16 rounded-2xl bg-teal-50 text-primary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="utensils-crossed" class="h-8 w-8"></i>
                </div>
                <h4 class="text-xl font-bold font-heading m-0">Rasa Otentik</h4>
                <p class="text-muted-foreground leading-relaxed">
                    Tidak perlu bingung mencari makan. Kami merekomendasikan kuliner legendaris dan masakan lokal autentik persis di sekitar destinasi Anda.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function cariWisataTerdekat() {
        const statusDiv = document.getElementById('status-lokasi');
        const carousel = document.getElementById('carousel-rekomendasi');
        const btn = document.getElementById('btn-lokasi');
        
        statusDiv.style.display = 'flex';
        statusDiv.innerHTML = '<i data-lucide="loader-2" class="animate-spin h-5 w-5 text-primary"></i> Meminta akses lokasi...';
        lucide.createIcons();
        carousel.style.display = 'none';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (posisi) => {
                    statusDiv.innerHTML = '<i data-lucide="loader-2" class="animate-spin h-5 w-5 text-primary"></i> Mencari destinasi di sekitarmu...';
                    lucide.createIcons();
                    kirimKeBackend(posisi.coords.latitude, posisi.coords.longitude);
                },
                (error) => {
                    statusDiv.innerHTML = '<i data-lucide="info" class="h-5 w-5 text-accent"></i> Akses lokasi ditolak. Menampilkan rekomendasi populer...';
                    lucide.createIcons();
                    kirimKeBackend(-7.5504, 110.8316); 
                }
            );
        } else {
            statusDiv.innerHTML = "<i data-lucide='alert-circle' class='h-5 w-5 text-red-500'></i> Browser tidak mendukung fitur lokasi.";
            lucide.createIcons();
        }
    }

    function kirimKeBackend(lat, lng) {
        const statusDiv = document.getElementById('status-lokasi');
        const carousel = document.getElementById('carousel-rekomendasi');
        
        axios.post('/api/rekomendasi-wisata', {
            latitude: lat,
            longitude: lng
        })
        .then(function (response) {
            const tempatWisata = response.data.data;
            
            if(tempatWisata.length === 0) {
                statusDiv.innerHTML = "<i data-lucide='info' class='h-5 w-5 text-muted-foreground'></i> Belum ada destinasi yang terdeteksi di area ini.";
                lucide.createIcons();
                return;
            }

            statusDiv.style.display = 'none';
            carousel.style.display = 'flex';
            
            let html = '';
            tempatWisata.forEach(tempat => {
                if(tempat.tags && tempat.tags.name) {
                    const tipe = tempat.tags.tourism || 'Wisata';
                    let urlDetail = `/detail-wisata?nama=${encodeURIComponent(tempat.tags.name)}`;
                    
                    // Card style modernized matching landing-page.tsx bento cards
                    html += `
                    <div class="carousel-card group relative overflow-hidden rounded-[1.5rem] bg-white border border-border shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full cursor-pointer" onclick="window.location.href='${urlDetail}'">
                        <div class="h-40 bg-muted flex items-center justify-center overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent z-10"></div>
                            <img src="https://images.unsplash.com/photo-1542898717-3bf7918d2eb4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Placeholder">
                            
                            <div class="absolute top-3 right-3 z-20">
                                <span class="inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-2.5 py-1 text-xs font-bold text-primary">
                                    <i data-lucide="tag" class="mr-1 h-3 w-3"></i> ${tipe.charAt(0).toUpperCase() + tipe.slice(1)}
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h5 class="font-bold font-heading text-lg text-foreground truncate group-hover:text-primary transition-colors" title="${tempat.tags.name}">${tempat.tags.name}</h5>
                            <p class="text-sm text-muted-foreground mt-1 mb-4 line-clamp-2 flex-1">Destinasi menarik di sekitar Anda yang wajib dikunjungi.</p>
                            
                            <div class="mt-auto flex items-center justify-between border-t border-border pt-4">
                                <span class="text-sm font-semibold text-primary">Lihat Detail</span>
                                <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
            });
            
            carousel.innerHTML = html;
            // Re-initialize icons for newly added HTML
            lucide.createIcons();
        })
        .catch(function (error) {
            statusDiv.innerHTML = "<i data-lucide='alert-triangle' class='h-5 w-5 text-red-500'></i> <span class='text-red-500 font-medium'>Terjadi kesalahan saat memuat data.</span>";
            lucide.createIcons();
            console.error(error);
        });
    }
</script>
@endsection