@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-foreground flex items-center gap-3">
                <i data-lucide="users" class="h-8 w-8 text-primary"></i> Kelola Pengunjung
            </h1>
            <p class="text-muted-foreground mt-2">Daftar semua akun yang terdaftar di Nusago Explorer</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-primary transition-all shadow-sm text-sm font-medium text-decoration-none">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Dasbor
        </a>
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
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peran (Role)</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengunjung as $index => $p)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->name) }}&background=e3342f&color=fff&size=40" class="w-10 h-10 rounded-full shadow-sm">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 m-0">{{ $p->name }}</p>
                                        <p class="text-xs text-gray-500 m-0">{{ $p->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($p->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i data-lucide="shield" class="h-3 w-3"></i> Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i data-lucide="user" class="h-3 w-3"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.pengunjung.edit', $p->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors" title="Edit">
                                        <i data-lucide="edit-2" class="h-4 w-4"></i>
                                    </a>
                                    
                                    @if($p->id !== auth()->id())
                                    <form action="{{ route('admin.pengunjung.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" title="Tidak dapat menghapus diri sendiri">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <i data-lucide="users" class="h-8 w-8 text-gray-300"></i>
                                    <p class="m-0">Belum ada pengunjung terdaftar.</p>
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
