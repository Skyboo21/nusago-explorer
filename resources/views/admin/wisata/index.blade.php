@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-foreground flex items-center gap-3">
                <i data-lucide="map" class="h-8 w-8 text-primary"></i> Kelola Wisata
            </h1>
            <p class="text-muted-foreground mt-2">Daftar destinasi wisata yang tersedia di aplikasi</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-primary transition-all shadow-sm text-sm font-medium text-decoration-none">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
            <a href="{{ route('admin.wisata.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary rounded-xl text-white hover:bg-primary/90 transition-all shadow-sm shadow-primary/30 text-sm font-medium text-decoration-none">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Wisata
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-green-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Destinasi</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($wisata as $index => $w)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    @if($w->gambar)
                                        <img src="{{ Storage::url($w->gambar) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                            <i data-lucide="image" class="h-5 w-5"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 m-0">{{ $w->nama_wisata }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-600 m-0">{{ $w->lokasi }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-1 text-amber-500">
                                    <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                                    <span class="text-sm font-medium text-gray-700">{{ $w->rating ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.wisata.edit', $w->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors" title="Edit">
                                        <i data-lucide="edit-2" class="h-4 w-4"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.wisata.destroy', $w->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus wisata ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <i data-lucide="map-pin-off" class="h-10 w-10 text-gray-300"></i>
                                    <p class="m-0 text-base">Belum ada data destinasi wisata.</p>
                                    <a href="{{ route('admin.wisata.create') }}" class="mt-2 text-primary hover:underline text-sm font-medium">Tambah Wisata Pertama</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
