@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-foreground flex items-center gap-3">
                <i data-lucide="shield-check" class="h-8 w-8 text-primary"></i> Admin Dashboard
            </h1>
            <p class="text-muted-foreground mt-2 m-0">Selamat datang di pusat kendali Nusago Explorer</p>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-50 text-red-600 font-medium hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-100">
                <i data-lucide="log-out" class="h-4 w-4"></i> LOGOUT
            </button>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-sm border border-border flex items-center justify-between border-l-4 border-l-primary hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Pengunjung</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 m-0">{{ $totalPengunjung }}</h3>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="users" class="h-5 w-5 sm:h-6 sm:w-6"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-sm border border-border flex items-center justify-between border-l-4 border-l-primary hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Wisata</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 m-0">{{ \App\Models\Wisata::count() }}</h3>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="map" class="h-5 w-5 sm:h-6 sm:w-6"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-sm border border-border flex items-center justify-between border-l-4 border-l-primary hover:shadow-md transition-shadow sm:col-span-2 lg:col-span-1">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Review</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 m-0">{{ $totalReview }}</h3>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="message-square" class="h-5 w-5 sm:h-6 sm:w-6"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        <!-- Pengunjung Terbaru -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] shadow-sm border border-border p-5 sm:p-8">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2 mb-4 sm:mb-6">
                <i data-lucide="user-plus" class="h-5 w-5 text-primary"></i> Pengunjung Terbaru
            </h2>
            
            <div class="space-y-3 sm:space-y-4">
                @forelse($pengunjungBaru as $p)
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->name) }}&background=e3342f&color=fff&size=40" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full shadow-sm">
                            <div>
                                <p class="text-xs sm:text-sm font-semibold text-gray-900 m-0">{{ $p->name }}</p>
                                <p class="text-[10px] sm:text-xs text-gray-500 m-0 truncate w-32 sm:w-auto">{{ $p->email }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] sm:text-xs font-medium text-gray-500 bg-white px-2 py-1 rounded-lg border border-gray-200 whitespace-nowrap">
                            {{ $p->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 sm:py-8 text-gray-500 text-sm">
                        Belum ada pengunjung.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Menu Akses Admin -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] shadow-sm border border-border p-5 sm:p-8">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2 mb-4 sm:mb-6">
                <i data-lucide="layout-grid" class="h-5 w-5 text-primary"></i> Menu Akses Cepat
            </h2>
            
            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <a href="{{ route('admin.pengunjung.index') }}" class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="users" class="h-5 w-5 sm:h-6 sm:w-6"></i>
                    </div>
                    <span class="font-medium text-xs sm:text-sm text-gray-900 text-center">Kelola Pengunjung</span>
                </a>
                
                <a href="{{ route('admin.wisata.index') }}" class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="map" class="h-5 w-5 sm:h-6 sm:w-6"></i>
                    </div>
                    <span class="font-medium text-xs sm:text-sm text-gray-900 text-center">Kelola Wisata</span>
                </a>
                
                <a href="{{ route('admin.review.index') }}" class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="message-square" class="h-5 w-5 sm:h-6 sm:w-6"></i>
                    </div>
                    <span class="font-medium text-xs sm:text-sm text-gray-900 text-center">Kelola Review</span>
                </a>
                
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="home" class="h-5 w-5 sm:h-6 sm:w-6"></i>
                    </div>
                    <span class="font-medium text-xs sm:text-sm text-gray-900 text-center">Dasbor Utama</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
