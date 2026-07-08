@extends('layouts.app')

@section('content')
<div class="container max-w-5xl mx-auto px-4 py-8 md:py-12">
    
    <!-- Header Misi Harian -->
    <div class="mb-10 animate-[fadeIn_0.5s_ease-out]">
        <div class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs sm:text-sm font-medium text-orange-600 mb-4 border border-orange-100">
            <i data-lucide="target" class="mr-2 h-4 w-4"></i> Misi Tersedia
        </div>
        <h1 class="text-3xl md:text-4xl font-bold font-heading text-foreground mb-3">
            Misi Harian <span class="text-orange-500">NusaGo</span> 🎯
        </h1>
        <p class="text-muted-foreground text-base md:text-lg max-w-2xl">
            Selesaikan misi harianmu untuk mengumpulkan poin, tingkatkan level Explorer-mu, dan dapatkan badge eksklusif! Misi akan direset setiap tengah malam.
        </p>
    </div>

    <!-- Progress Keseluruhan -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-border mb-8 flex flex-col md:flex-row items-center gap-6 animate-[slideUp_0.6s_ease-out]">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 flex-shrink-0">
            <i data-lucide="award" class="h-10 w-10"></i>
        </div>
        <div class="flex-1 w-full">
            <div class="flex justify-between items-end mb-2">
                <div>
                    <h3 class="text-lg font-bold text-foreground">Progress Hari Ini</h3>
                    <p class="text-sm text-muted-foreground">Selesaikan semua misi untuk bonus koin +500</p>
                </div>
                <span class="text-2xl font-bold text-orange-600 font-heading">1/3</span>
            </div>
            <div class="h-4 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-orange-400 to-red-500 rounded-full transition-all duration-1000" style="width: 33%"></div>
            </div>
        </div>
    </div>

    <!-- Daftar Misi -->
    <div class="space-y-4">
        
        <!-- Misi 1 (Selesai) -->
        <div class="bg-white rounded-[2rem] p-5 md:p-6 border-2 border-teal-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 relative overflow-hidden transition-transform hover:-translate-y-1">
            <div class="absolute -right-6 -top-6 h-24 w-24 bg-teal-50 rounded-full opacity-50 z-0"></div>
            
            <div class="w-14 h-14 rounded-2xl bg-teal-500 text-white flex items-center justify-center shadow-md flex-shrink-0 z-10">
                <i data-lucide="check-circle" class="h-7 w-7"></i>
            </div>
            
            <div class="flex-1 z-10">
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-teal-100 text-teal-700">Selesai</span>
                    <span class="text-sm font-bold text-orange-500 flex items-center gap-1"><i data-lucide="coins" class="h-3 w-3"></i> +50 Poin</span>
                </div>
                <h3 class="text-lg font-bold text-foreground line-through text-opacity-70">Jelajahi 3 Destinasi Wisata</h3>
                <p class="text-sm text-muted-foreground m-0">Kunjungi halaman detail wisata minimal 3 kali.</p>
            </div>
            
            <div class="w-full sm:w-auto mt-4 sm:mt-0 z-10">
                <button disabled class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gray-100 text-gray-400 font-bold cursor-not-allowed border border-gray-200">
                    Diklaim
                </button>
            </div>
        </div>

        <!-- Misi 2 (Belum Selesai) -->
        <div class="bg-white rounded-[2rem] p-5 md:p-6 border border-border shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 relative overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md">
            
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 flex-shrink-0 z-10">
                <i data-lucide="message-square-quote" class="h-6 w-6"></i>
            </div>
            
            <div class="flex-1 w-full z-10">
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-gray-100 text-gray-600">Berjalan</span>
                    <span class="text-sm font-bold text-orange-500 flex items-center gap-1"><i data-lucide="coins" class="h-3 w-3"></i> +100 Poin</span>
                </div>
                <h3 class="text-lg font-bold text-foreground">Tinggalkan 1 Ulasan Destinasi</h3>
                <p class="text-sm text-muted-foreground mb-3">Bagikan pengalamanmu di salah satu tempat wisata.</p>
                
                <!-- Mini Progress -->
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: 0%"></div>
                    </div>
                    <span class="text-xs font-bold text-muted-foreground">0/1</span>
                </div>
            </div>
            
            <div class="w-full sm:w-auto mt-4 sm:mt-0 z-10">
                <a href="{{ route('review.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-2.5 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-sm text-decoration-none">
                    Lakukan
                </a>
            </div>
        </div>

        <!-- Misi 3 (Belum Selesai) -->
        <div class="bg-white rounded-[2rem] p-5 md:p-6 border border-border shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 relative overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md">
            
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 flex-shrink-0 z-10">
                <i data-lucide="bot" class="h-6 w-6"></i>
            </div>
            
            <div class="flex-1 w-full z-10">
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-gray-100 text-gray-600">Berjalan</span>
                    <span class="text-sm font-bold text-orange-500 flex items-center gap-1"><i data-lucide="coins" class="h-3 w-3"></i> +150 Poin</span>
                </div>
                <h3 class="text-lg font-bold text-foreground">Tanya NusaBot 3 Kali</h3>
                <p class="text-sm text-muted-foreground mb-3">Cari tahu informasi wisata atau kuliner dari asisten AI kami.</p>
                
                <!-- Mini Progress -->
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-500 rounded-full" style="width: 33%"></div>
                    </div>
                    <span class="text-xs font-bold text-muted-foreground">1/3</span>
                </div>
            </div>
            
            <div class="w-full sm:w-auto mt-4 sm:mt-0 z-10">
                <a href="{{ route('chatbot.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-2.5 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-sm text-decoration-none">
                    Lakukan
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
