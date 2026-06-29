@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-foreground flex items-center gap-3">
            <i data-lucide="shield-check" class="h-8 w-8 text-primary"></i> Admin Dashboard
        </h1>
        <p class="text-muted-foreground mt-2">Selamat datang di pusat kendali Nusago Explorer</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-border flex items-center justify-between border-l-4 border-l-primary hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengunjung</p>
                <h3 class="text-3xl font-bold text-gray-900 m-0">{{ $totalPengunjung }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="users" class="h-6 w-6"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-border flex items-center justify-between border-l-4 border-l-primary hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Wisata</p>
                <h3 class="text-3xl font-bold text-gray-900 m-0">{{ \App\Models\Wisata::count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="map" class="h-6 w-6"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-border flex items-center justify-between border-l-4 border-l-primary hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Review</p>
                <h3 class="text-3xl font-bold text-gray-900 m-0">{{ $totalReview }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <i data-lucide="message-square" class="h-6 w-6"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Pengunjung Terbaru -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-border p-6 sm:p-8">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-6">
                <i data-lucide="user-plus" class="h-5 w-5 text-primary"></i> Pengunjung Terbaru
            </h2>
            
            <div class="space-y-4">
                @forelse($pengunjungBaru as $p)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->name) }}&background=e3342f&color=fff&size=40" class="w-10 h-10 rounded-full shadow-sm">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 m-0">{{ $p->name }}</p>
                                <p class="text-xs text-gray-500 m-0">{{ $p->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-gray-500 bg-white px-2 py-1 rounded-lg border border-gray-200">
                            {{ $p->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        Belum ada pengunjung.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Menu Akses Admin -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-border p-6 sm:p-8">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-6">
                <i data-lucide="layout-grid" class="h-5 w-5 text-primary"></i> Menu Akses Cepat
            </h2>
            
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.pengunjung.index') }}" class="flex flex-col items-center justify-center p-6 rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="users" class="h-6 w-6"></i>
                    </div>
                    <span class="font-medium text-sm text-gray-900">Kelola Pengunjung</span>
                </a>
                
                <a href="{{ route('admin.wisata.index') }}" class="flex flex-col items-center justify-center p-6 rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="map" class="h-6 w-6"></i>
                    </div>
                    <span class="font-medium text-sm text-gray-900">Kelola Wisata</span>
                </a>
                
                <a href="{{ route('admin.review.index') }}" class="flex flex-col items-center justify-center p-6 rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="message-square" class="h-6 w-6"></i>
                    </div>
                    <span class="font-medium text-sm text-gray-900">Kelola Review</span>
                </a>
                
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center p-6 rounded-[1.5rem] bg-gray-50 border border-gray-100 hover:bg-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all group text-decoration-none">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-primary mb-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="home" class="h-6 w-6"></i>
                    </div>
                    <span class="font-medium text-sm text-gray-900">Dasbor Utama</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
