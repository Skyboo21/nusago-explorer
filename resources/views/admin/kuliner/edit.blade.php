@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Form -->
    <div class="mb-8">
        <a href="{{ route('admin.kuliner.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-4">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Daftar Kuliner
        </a>
        <h1 class="text-3xl font-bold text-foreground flex items-center gap-3">
            <i data-lucide="pencil" class="h-8 w-8 text-primary"></i> Edit Kuliner
        </h1>
        <p class="text-muted-foreground mt-2">Perbarui informasi destinasi kuliner "{{ $kuliner->nama_kuliner }}"</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-border p-6 sm:p-8">
        <form action="{{ route('admin.kuliner.update', $kuliner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Kuliner -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kuliner *</label>
                    <input type="text" name="nama_kuliner" value="{{ old('nama_kuliner', $kuliner->nama_kuliner) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" required>
                    @error('nama_kuliner') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Daerah & Harga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daerah / Lokasi</label>
                    <input type="text" name="daerah" value="{{ old('daerah', $kuliner->daerah) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Estimasi (Rp)</label>
                    <input type="number" name="harga_estimasi" value="{{ old('harga_estimasi', $kuliner->harga_estimasi) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>

                <!-- ✅ DROPDOWN WISATA TERKAIT (BARU) -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Sekitar Wisata</label>
                    <select name="wisata_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white">
                        <option value="">-- Tidak Terkait Wisata Spesifik --</option>
                        @foreach(\App\Models\Wisata::all() as $wisata)
                            <!-- Perhatikan fallback $kuliner->wisata_id ?? '' agar data lama terpilih -->
                            <option value="{{ $wisata->id }}" {{ old('wisata_id', $kuliner->wisata_id ?? '') == $wisata->id ? 'selected' : '' }}>
                                {{ $wisata->nama_wisata }} ({{ $wisata->daerah }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Pilih wisata terdekat agar kuliner muncul di fitur "Sekitar Lokasi".</p>
                </div>

                <!-- Deskripsi Full Width -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kuliner</label>
                    <textarea name="deskripsi_kuliner" rows="4" 
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">{{ old('deskripsi_kuliner', $kuliner->deskripsi_kuliner) }}</textarea>
                </div>

                <!-- Rating & Jam Operasional -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating (0-5)</label>
                    <input type="number" step="0.1" name="rating" value="{{ old('rating', $kuliner->rating) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                    <input type="text" name="jam_operasional" value="{{ old('jam_operasional', $kuliner->jam_operasional) }}" placeholder="Cth: 08:00 - 21:00"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>

                <!-- Koordinat Maps -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude', $kuliner->latitude) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude', $kuliner->longitude) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>

                <!-- Link Maps -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                    <input type="url" name="link_maps" value="{{ old('link_maps', $kuliner->link_maps) }}" placeholder="https://maps.google.com/..."
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>

                <!-- Upload Gambar (Dengan Preview Lama) -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kuliner</label>
                    
                    @if($kuliner->gambar_kuliner)
                        <div class="mb-3 relative inline-block">
                            <img src="{{ asset('storage/' . $kuliner->gambar_kuliner) }}" alt="Gambar Lama" class="h-32 w-32 object-cover rounded-xl border border-gray-200 shadow-sm">
                            <span class="absolute top-2 right-2 bg-black/50 text-white text-[10px] px-2 py-1 rounded-full backdrop-blur-sm">Gambar Saat Ini</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Upload gambar baru untuk mengganti.</p>
                    @endif

                    <input type="file" name="gambar_kuliner" accept="image/*" 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    @error('gambar_kuliner') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status Halal -->
                <div class="col-span-2">
                    <div class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 bg-gray-50/50">
                        <input type="checkbox" name="is_halal" id="is_halal" value="1" 
                               {{ old('is_halal', $kuliner->is_halal) ? 'checked' : '' }}
                               class="w-5 h-5 text-primary rounded border-gray-300 focus:ring-primary cursor-pointer">
                        <label for="is_halal" class="text-sm font-medium text-gray-700 cursor-pointer select-none">
                            Centang jika kuliner ini bersertifikat Halal
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-border flex justify-end gap-3">
                <a href="{{ route('admin.kuliner.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white font-medium hover:bg-primary/90 shadow-sm transition-all flex items-center gap-2">
                    <i data-lucide="save" class="h-4 w-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection