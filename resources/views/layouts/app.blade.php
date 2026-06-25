<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusago Explorer - Jelajah, Rasa, & Cerita</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            color: #e63946 !important; /* Merah Khas Indonesia */
            font-weight: 700;
            letter-spacing: 1px;
        }
        .nav-link {
            font-weight: 600;
            color: #2b2d42 !important;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #e63946 !important;
        }
        .btn-custom {
            background-color: #e63946;
            color: white;
            border-radius: 30px;
            padding: 8px 25px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #d62828;
            color: white;
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.4);
        }
        footer {
            background-color: #1d3557;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fa-solid fa-map-location-dot me-2"></i>NUSAGO EXPLORER
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/destinasi">Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pemandu Lokal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kuliner</a></li>
                    
                    @guest
                        <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                            <a class="btn btn-custom" href="{{ route('login') }}">Masuk / Daftar</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item dropdown ms-lg-3 mt-3 mt-lg-0">
                            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user me-1 text-danger"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                <li>
                                    <a class="dropdown-item fw-bold py-2" href="{{ route('dashboard') }}">
                                        <i class="fa-solid fa-chart-line me-2 text-primary"></i> Dashboard
                                    </a>
                                </li>
                                
                                <li><hr class="dropdown-divider"></li>
                                
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger small fw-bold py-2">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2026 Nusago Explorer. Pesona Indonesia di Ujung Jari.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>