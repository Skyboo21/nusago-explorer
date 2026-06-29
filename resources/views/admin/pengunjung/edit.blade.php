@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.pengunjung.index') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-primary hover:border-primary transition-all shadow-sm text-decoration-none">
            <i data-lucide="arrow-left" class="h-5 w-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-foreground">Edit Pengguna</h1>
            <p class="text-muted-foreground mt-1 text-sm">Ubah detail dan hak akses pengguna</p>
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
        <div class="flex items-center gap-4 mb-8 pb-8 border-b border-gray-100">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=e3342f&color=fff&size=80" class="w-16 h-16 rounded-full shadow-sm">
            <div>
                <p class="text-lg font-semibold text-gray-900 m-0">{{ $user->name }}</p>
                <p class="text-sm text-gray-500 m-0">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('admin.pengunjung.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                </div>

                <!-- Email (Readonly) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Tidak bisa diubah)</label>
                    <input type="email" id="email" value="{{ $user->email }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 outline-none cursor-not-allowed" disabled>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hak Akses (Role)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm focus:outline-none {{ old('role', $user->role) === 'user' ? 'border-primary ring-1 ring-primary' : 'border-gray-200' }}">
                            <input type="radio" name="role" value="user" class="sr-only" {{ old('role', $user->role) === 'user' ? 'checked' : '' }} onchange="this.parentElement.classList.add('border-primary', 'ring-1', 'ring-primary'); this.parentElement.nextElementSibling.classList.remove('border-primary', 'ring-1', 'ring-primary');">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900 flex items-center gap-2">
                                        <i data-lucide="user" class="h-4 w-4 text-blue-500"></i> Pengguna Biasa (User)
                                    </span>
                                    <span class="mt-1 flex items-center text-sm text-gray-500">Hanya dapat mengakses fitur utama.</span>
                                </span>
                            </span>
                            <i data-lucide="check-circle-2" class="h-5 w-5 text-primary {{ old('role', $user->role) === 'user' ? 'opacity-100' : 'opacity-0' }} transition-opacity"></i>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm focus:outline-none {{ old('role', $user->role) === 'admin' ? 'border-primary ring-1 ring-primary' : 'border-gray-200' }}">
                            <input type="radio" name="role" value="admin" class="sr-only" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }} onchange="this.parentElement.classList.add('border-primary', 'ring-1', 'ring-primary'); this.parentElement.previousElementSibling.classList.remove('border-primary', 'ring-1', 'ring-primary');">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900 flex items-center gap-2">
                                        <i data-lucide="shield" class="h-4 w-4 text-red-500"></i> Administrator
                                    </span>
                                    <span class="mt-1 flex items-center text-sm text-gray-500">Akses penuh ke Admin Panel.</span>
                                </span>
                            </span>
                            <i data-lucide="check-circle-2" class="h-5 w-5 text-primary {{ old('role', $user->role) === 'admin' ? 'opacity-100' : 'opacity-0' }} transition-opacity"></i>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pengunjung.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors text-decoration-none">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-medium shadow-sm shadow-primary/30 hover:bg-primary/90 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="h-4 w-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
