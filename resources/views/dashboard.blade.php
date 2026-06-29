@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto px-4 py-8 md:py-12">
    
    <!-- Dashboard Header -->
    <div class="mb-10 animate-[fadeIn_0.5s_ease-out]">
        <div class="inline-flex items-center rounded-full bg-teal-50 px-3 py-1 text-sm font-medium text-primary mb-4 border border-teal-100">
            <i data-lucide="layout-dashboard" class="mr-2 h-4 w-4"></i> Pusat Komando
        </div>
        <h1 class="text-3xl md:text-4xl font-bold font-heading text-foreground mb-2">
            Halo, {{ explode(' ', $userProfile['nama'])[0] }}! <span class="text-2xl animate-[wave_2s_infinite]">👋</span>
        </h1>
        <p class="text-muted-foreground text-lg max-w-2xl">
            Selamat datang kembali di pusat komandomu. Siap untuk petualangan seru hari ini?
        </p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- CARD 1: Profil Pengguna (Bento Box Kiri) -->
        <div class="lg:col-span-1 group relative overflow-hidden rounded-[2rem] border border-border bg-white shadow-sm hover:shadow-xl transition-all duration-300">
            <!-- Background Decoration -->
            <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-teal-50 group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
            
            <div class="p-8 relative z-10 flex flex-col items-center text-center">
                <div class="relative mb-6">
                    <img src="{{ $userProfile['avatar'] }}" alt="Profil" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg shadow-teal-900/10 group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md">
                        <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center">
                            <i data-lucide="camera" class="h-4 w-4"></i>
                        </div>
                    </div>
                </div>
                
                <h2 class="text-2xl font-bold font-heading text-foreground m-0">{{ $userProfile['nama'] }}</h2>
                <div class="inline-flex items-center gap-1.5 text-accent font-medium mt-2 mb-6 bg-orange-50 px-3 py-1 rounded-full text-sm">
                    <i data-lucide="map-pin" class="h-4 w-4"></i> {{ $userProfile['asal'] }}
                </div>
                
                <div class="w-full space-y-4 text-left">
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50 border border-gray-100 hover:border-teal-200 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-muted-foreground shadow-sm">
                            <i data-lucide="mail" class="h-5 w-5"></i>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-xs text-muted-foreground font-semibold uppercase tracking-wider mb-0.5">Email</p>
                            <p class="text-sm font-medium text-foreground truncate m-0">{{ $userProfile['email'] }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50 border border-gray-100 hover:border-teal-200 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-muted-foreground shadow-sm">
                            <i data-lucide="calendar" class="h-5 w-5"></i>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-xs text-muted-foreground font-semibold uppercase tracking-wider mb-0.5">Bergabung</p>
                            <p class="text-sm font-medium text-foreground truncate m-0">{{ $userProfile['bergabung'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 rounded-2xl bg-teal-50/50 border border-teal-100/50 w-full relative">
                    <i data-lucide="quote" class="absolute top-2 left-2 h-4 w-4 text-primary/20"></i>
                    <p class="text-sm font-medium text-teal-800 italic m-0 px-2 pt-2 text-center">
                        "{{ $userProfile['bio'] }}"
                    </p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (Statistik & Akses Cepat) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- CARD 2: Statistik (Bento Box Atas) -->
            <div class="rounded-[2rem] border border-border bg-white p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold font-heading flex items-center gap-2 m-0">
                        <i data-lucide="bar-chart-3" class="h-6 w-6 text-primary"></i> Statistik Eksplorasi
                    </h3>
                    <a href="#" class="text-sm font-medium text-primary hover:underline">Lihat Detail</a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-yellow-50 to-orange-50 border border-orange-100 hover:border-orange-200 transition-colors relative overflow-hidden">
                        <i data-lucide="award" class="absolute -right-2 -bottom-2 h-16 w-16 text-orange-500/10 group-hover:scale-110 transition-transform"></i>
                        <p class="text-xs font-bold text-orange-600/70 uppercase tracking-wider mb-2">Level Saat Ini</p>
                        <p class="text-lg font-bold text-orange-700 m-0 leading-tight">{{ $userStats['level'] }}</p>
                    </div>
                    
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-teal-50 to-emerald-50 border border-teal-100 hover:border-teal-200 transition-colors relative overflow-hidden">
                        <i data-lucide="star" class="absolute -right-2 -bottom-2 h-16 w-16 text-teal-500/10 group-hover:scale-110 transition-transform"></i>
                        <p class="text-xs font-bold text-teal-600/70 uppercase tracking-wider mb-2">Total Poin</p>
                        <p class="text-3xl font-bold text-teal-700 m-0 font-heading">{{ $userStats['total_poin'] }}</p>
                    </div>
                    
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 hover:border-blue-200 transition-colors relative overflow-hidden">
                        <i data-lucide="map" class="absolute -right-2 -bottom-2 h-16 w-16 text-blue-500/10 group-hover:scale-110 transition-transform"></i>
                        <p class="text-xs font-bold text-blue-600/70 uppercase tracking-wider mb-2">Lokasi Dikunjungi</p>
                        <p class="text-3xl font-bold text-blue-700 m-0 font-heading">{{ $userStats['lokasi_dikunjungi'] }}</p>
                    </div>
                </div>
            </div>

            <!-- CARD 3: Akses Cepat (Bento Box Bawah) -->
            <div class="rounded-[2rem] border border-border bg-white p-8 shadow-sm hover:shadow-xl transition-shadow duration-300 flex-1">
                <h3 class="text-xl font-bold font-heading flex items-center gap-2 mb-6 m-0">
                    <i data-lucide="zap" class="h-6 w-6 text-accent"></i> Akses Cepat
                </h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($quickAccess as $menu)
                        <!-- Note: Because the old controller sends FontAwesome icons like 'fa-solid fa-map', 
                             we will try to map them to Lucide manually if possible, or just use a generic icon.
                             We can extract the last part of fa-xxx to try matching it. -->
                        @php
                            $lucideIcon = 'grid'; // default
                            if (str_contains($menu['icon'], 'map')) $lucideIcon = 'map';
                            if (str_contains($menu['icon'], 'bullseye') || str_contains($menu['icon'], 'target')) $lucideIcon = 'target';
                            if (str_contains($menu['icon'], 'utensils')) $lucideIcon = 'utensils';
                            if (str_contains($menu['icon'], 'gear') || str_contains($menu['icon'], 'cog')) $lucideIcon = 'settings';
                            if (str_contains($menu['icon'], 'shield')) $lucideIcon = 'shield';
                        @endphp
                        
                        <a href="{{ $menu['url'] }}" class="group flex flex-col items-center justify-center p-4 rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary hover:border-primary transition-all duration-300 text-decoration-none">
                            <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i data-lucide="{{ $lucideIcon }}" class="h-6 w-6 text-primary"></i>
                            </div>
                            <span class="text-sm font-semibold text-foreground group-hover:text-white text-center">{{ $menu['nama'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- CARD 4: Aktivitas Terbaru (Full Width) -->
    <div class="rounded-[2rem] border border-border bg-white shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden">
        <div class="p-8 border-b border-border bg-gray-50/50 flex items-center justify-between">
            <h3 class="text-xl font-bold font-heading flex items-center gap-2 m-0">
                <i data-lucide="clock" class="h-6 w-6 text-primary"></i> Aktivitas Terbarumu
            </h3>
            <button class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors border-0 bg-transparent">Tandai semua dibaca</button>
        </div>
        
        <div class="divide-y divide-border">
            @forelse($recentActivities as $aktivitas)
                <div class="p-6 hover:bg-gray-50 transition-colors flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-teal-50 border border-teal-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i data-lucide="check-circle-2" class="h-5 w-5 text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-medium text-foreground m-0">{{ $aktivitas->deskripsi }}</p>
                        <p class="text-sm text-muted-foreground m-0 mt-1 flex items-center gap-1">
                            <i data-lucide="calendar" class="h-3.5 w-3.5"></i> {{ $aktivitas->waktu }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-muted-foreground">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="inbox" class="h-8 w-8 text-gray-400"></i>
                    </div>
                    <p class="text-lg font-medium text-gray-600">Belum ada aktivitas</p>
                    <p class="text-sm mt-1">Mulai jelajahi destinasi untuk mencatat petualanganmu!</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<style>
    /* Custom Keyframes for some micro-interactions */
    @keyframes wave {
        0% { transform: rotate(0deg); }
        10% { transform: rotate(14deg); }
        20% { transform: rotate(-8deg); }
        30% { transform: rotate(14deg); }
        40% { transform: rotate(-4deg); }
        50% { transform: rotate(10deg); }
        60% { transform: rotate(0deg); }
        100% { transform: rotate(0deg); }
    }
</style>
@endsection