@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-foreground flex items-center gap-3">
                <i data-lucide="utensils" class="h-8 w-8 text-primary"></i> Kelola Kuliner
            </h1>
            <p class="text-muted-foreground mt-2">Daftar destinasi kuliner yang tersedia di aplikasi</p>
        </div>
        
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-primary transition-all shadow-sm text-sm font-medium text-decoration-none whitespace-nowrap">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
            
            <a href="{{ route('admin.kuliner.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all shadow-sm text-sm font-medium text-decoration-none whitespace-nowrap">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Kuliner
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-green-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Card Container -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-border">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kuliner</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Daerah</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($kuliners as $kuliner)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-gray-900 m-0">{{ $kuliner->nama_kuliner }}</p>
                            <p class="text-xs text-gray-400 m-0 truncate max-w-[200px]">{{ Str::limit($kuliner->deskripsi_kuliner, 40) }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $kuliner->daerah ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($kuliner->harga_estimasi ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                <i data-lucide="star" class="h-3 w-3 fill-current"></i> {{ $kuliner->rating ?? 0 }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($kuliner->is_halal)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                    <i data-lucide="check-circle-2" class="h-3 w-3"></i> Halal
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                    Non-Halal
                                </span>
                            @endif
                        </td>
                        
                        <!-- ✅ KOLOM AKSI (SUDAH DIPERBAIKI MATCH DENGAN TEMANMU) -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Tombol Edit (Link) -->
                                <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" 
                                   class="w-9 h-9 rounded-full bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white flex items-center justify-center transition-all shadow-sm border border-orange-100"
                                   title="Edit Data">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                </a>
                                
                                <!-- Tombol Hapus (Form Delete) -->
                                <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuliner ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="w-9 h-9 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm border border-red-100"
                                            title="Hapus Data">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i data-lucide="utensils-off" class="h-12 w-12 text-gray-300"></i>
                                <p class="m-0 text-lg font-medium text-gray-400">Belum ada data destinasi kuliner.</p>
                                <a href="{{ route('admin.kuliner.create') }}" class="text-primary text-sm hover:underline mt-2">Tambahkan Kuliner Pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($kuliners->hasPages())
        <div class="px-6 py-4 border-t border-border bg-gray-50/30">
            {{ $kuliners->links() }}
        </div>
        @endif
    </div>
</div>
@endsection