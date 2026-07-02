@extends('layouts.app')

@section('content')
<div class="container max-w-4xl mx-auto px-4 py-8 md:py-12">
    
    <!-- Dashboard Header -->
    <div class="mb-10 animate-[fadeIn_0.5s_ease-out]">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-muted-foreground hover:text-primary mb-4 transition-colors">
            <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-heading text-foreground mb-2">
            Pengaturan Profil
        </h1>
        <p class="text-muted-foreground text-base sm:text-lg m-0">
            Kelola informasi pribadi dan keamanan akun kamu di sini.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center gap-3">
            <i data-lucide="check-circle" class="h-5 w-5"></i>
            <p class="m-0 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('status'))
        <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center gap-3">
            <i data-lucide="check-circle" class="h-5 w-5"></i>
            <p class="m-0 text-sm font-medium">{{ session('status') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- SIDEBAR NAV (Optional UI element for aesthetics) -->
        <div class="md:col-span-1">
            <div class="rounded-2xl border border-border bg-white shadow-sm overflow-hidden sticky top-24">
                <div class="p-4 bg-gray-50/50 border-b border-border">
                    <p class="text-xs font-bold text-muted-foreground uppercase tracking-wider m-0">Menu Pengaturan</p>
                </div>
                <div class="p-2 space-y-1">
                    <a href="#profil" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-teal-50 text-teal-700 font-medium transition-colors">
                        <i data-lucide="user" class="h-4 w-4"></i> Data Diri
                    </a>
                    <a href="#keamanan" class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground hover:bg-gray-50 transition-colors">
                        <i data-lucide="shield" class="h-4 w-4 text-muted-foreground"></i> Keamanan
                    </a>
                </div>
            </div>
        </div>

        <!-- MAIN FORM CONTENT -->
        <div class="md:col-span-2 space-y-8">
            
            <!-- BAGIAN 1: PROFIL -->
            <div id="profil" class="rounded-[2rem] border border-border bg-white shadow-sm overflow-hidden scroll-mt-24">
                <div class="p-6 sm:p-8 border-b border-border flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center flex-shrink-0 text-primary">
                        <i data-lucide="user" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold font-heading m-0">Informasi Data Diri</h2>
                        <p class="text-sm text-muted-foreground m-0 mt-1">Perbarui foto profil, nama, dan alamat email kamu.</p>
                    </div>
                </div>
                
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6 m-0">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Upload -->
                        <div class="flex items-start gap-6">
                            <div class="relative group cursor-pointer" onclick="document.getElementById('avatar_upload').click()">
                                @php
                                    $avatarUrl = $user->avatar ? $user->avatar : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=e3342f&color=fff&size=128';
                                @endphp
                                <img src="{{ $avatarUrl }}" id="avatar_preview" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border-4 border-gray-50 shadow-sm transition-transform group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i data-lucide="camera" class="h-6 w-6 text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-foreground mb-2">Foto Profil</label>
                                <input type="file" name="avatar" id="avatar_upload" accept="image/*" class="hidden" onchange="previewImage(this)">
                                <button type="button" onclick="document.getElementById('avatar_upload').click()" class="px-4 py-2 bg-white border border-border rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors">
                                    Pilih Foto Baru
                                </button>
                                <p class="text-xs text-muted-foreground mt-2 m-0">Format: JPG, PNG. Ukuran maksimal 2MB.</p>
                                @error('avatar')
                                    <p class="text-red-500 text-xs mt-1 m-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-foreground">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="user" class="h-4 w-4 text-muted-foreground"></i>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="pl-10 w-full rounded-xl border-border bg-gray-50/50 focus:bg-white focus:ring-primary focus:border-primary sm:text-sm" placeholder="Nama Lengkap">
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs m-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-foreground">Alamat Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="h-4 w-4 text-muted-foreground"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="pl-10 w-full rounded-xl border-border bg-gray-50/50 focus:bg-white focus:ring-primary focus:border-primary sm:text-sm" placeholder="email@contoh.com">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs m-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-primary text-white font-medium rounded-xl hover:bg-teal-700 transition-colors shadow-sm flex items-center gap-2">
                                <i data-lucide="save" class="h-4 w-4"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- BAGIAN 2: KEAMANAN (GANTI PASSWORD) -->
            <div id="keamanan" class="rounded-[2rem] border border-border bg-white shadow-sm overflow-hidden scroll-mt-24">
                <div class="p-6 sm:p-8 border-b border-border flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0 text-red-600">
                        <i data-lucide="shield-alert" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold font-heading m-0">Ubah Password</h2>
                        <p class="text-sm text-muted-foreground m-0 mt-1">Pastikan akun kamu selalu aman dengan password yang kuat.</p>
                    </div>
                </div>
                
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('profile.password') }}" class="space-y-6 m-0">
                        @csrf
                        @method('PUT')

                        <!-- Password Lama -->
                        <div class="space-y-2">
                            <label for="current_password" class="block text-sm font-semibold text-foreground">Password Lama</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="key" class="h-4 w-4 text-muted-foreground"></i>
                                </div>
                                <input type="password" name="current_password" id="current_password" class="pl-10 w-full rounded-xl border-border bg-gray-50/50 focus:bg-white focus:ring-primary focus:border-primary sm:text-sm" placeholder="••••••••">
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-xs m-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="border-border">

                        <!-- Password Baru -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-foreground">Password Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="h-4 w-4 text-muted-foreground"></i>
                                </div>
                                <input type="password" name="password" id="password" class="pl-10 w-full rounded-xl border-border bg-gray-50/50 focus:bg-white focus:ring-primary focus:border-primary sm:text-sm" placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs m-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-semibold text-foreground">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="h-4 w-4 text-muted-foreground"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="pl-10 w-full rounded-xl border-border bg-gray-50/50 focus:bg-white focus:ring-primary focus:border-primary sm:text-sm" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white font-medium rounded-xl hover:bg-black transition-colors shadow-sm flex items-center gap-2">
                                <i data-lucide="check-shield" class="h-4 w-4"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Preview gambar sebelum diupload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('avatar_preview').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
