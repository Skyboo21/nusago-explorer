@extends('layouts.app')

@section('content')
<style>
    /* Menghilangkan jarak putih dari footer bawaan app.blade.php */
    footer { margin-top: 0 !important; }
    
    /* Membuat area login full dengan background gambar */
    .auth-wrapper {
        background: linear-gradient(rgba(29, 53, 87, 0.4), rgba(29, 53, 87, 0.8)), url('https://images.unsplash.com/photo-1537956965359-7573183d1f57?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
        min-height: calc(100vh - 144px); /* 100vh dikurangi perkiraan tinggi navbar & footer */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }
    
    /* Efek Glassmorphism (Kaca Transparan) untuk Card */
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }
    
    .glass-card h3, .glass-card p, .glass-card label {
        color: white !important;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
    }

    /* Kustomisasi Input Form agar menyatu dengan kaca */
    .glass-input {
        background: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        color: white !important;
    }
    
    .glass-input::placeholder {
        color: rgba(255, 255, 255, 0.8) !important;
    }
    
    .glass-input:focus {
        background: rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 0 10px rgba(230, 57, 70, 0.5) !important;
        border-color: #e63946 !important;
    }

    .glass-icon {
        background: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        color: white !important;
        border-right: none !important;
    }
</style>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card glass-card shadow-lg rounded-4 p-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <span class="fs-1 text-danger"><i class="fa-solid fa-compass"></i></span>
                            <h3 class="fw-bold mt-2">Selamat Datang</h3>
                            <p class="small">Masuk untuk menjelajahi keindahan Indonesia</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success border-0 small py-2 fw-bold text-center">{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger border-0 small py-2 fw-bold text-center">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-icon"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control glass-input" placeholder="nama@email.com" required value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-icon"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control glass-input" placeholder="••••••••" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-custom w-100 py-2 fw-bold mb-3">Masuk Sekarang</button>
                        </form>

                        <div class="text-center mt-3">
                            <p class="small mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-warning fw-bold text-decoration-none">Daftar di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection