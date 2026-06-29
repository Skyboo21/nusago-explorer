@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.wisata.index') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-primary hover:border-primary transition-all shadow-sm text-decoration-none">
            <i data-lucide="arrow-left" class="h-5 w-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-foreground">Tambah Destinasi Wisata</h1>
            <p class="text-muted-foreground mt-1 text-sm">Tambahkan destinasi baru ke dalam daftar eksplorasi</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl">
            <div class="flex items-center gap-2 mb-2 font-semibold">
                <i data-lucide="alert-circle" class="h-5 w-5"></i>
                <p class="m-0">Terdapat kesalahan:</p>
            </div>
            <ul class="list-disc list-inside text-sm m-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-border p-6 sm:p-8">
        <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Nama & Lokasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_wisata" class="block text-sm font-medium text-gray-700 mb-2">Nama Wisata *</label>
                        <input type="text" name="nama_wisata" id="nama_wisata" value="{{ old('nama_wisata') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" required placeholder="Cth: Candi Borobudur">
                    </div>
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi (Daerah) *</label>
                        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" required placeholder="Cth: Magelang, Jawa Tengah">
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Alamat lengkap tujuan wisata">{{ old('alamat') }}</textarea>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Wisata</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Ceritakan menariknya tempat ini...">{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Rating & Pengunjung -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating Awal (0-5)</label>
                        <input type="number" step="0.1" min="0" max="5" name="rating" id="rating" value="{{ old('rating') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Cth: 4.8">
                    </div>
                    <div>
                        <label for="jumlah_pengunjung" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Pengunjung</label>
                        <input type="number" min="0" name="jumlah_pengunjung" id="jumlah_pengunjung" value="{{ old('jumlah_pengunjung', 0) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                </div>

                <!-- Gambar -->
                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">Foto Destinasi</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors bg-gray-50/50">
                        <div class="space-y-1 text-center">
                            <i data-lucide="image-plus" class="mx-auto h-12 w-12 text-gray-400"></i>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="gambar" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary/80 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                    <span>Pilih gambar</span>
                                    <input id="gambar" name="gambar" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-end gap-3">
                <a href="{{ route('admin.wisata.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors text-decoration-none">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-medium shadow-sm shadow-primary/30 hover:bg-primary/90 transition-all flex items-center gap-2">
                    <i data-lucide="plus" class="h-4 w-4"></i> Tambahkan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
