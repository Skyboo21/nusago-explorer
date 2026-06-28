<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusago Explorer - Jelajah, Rasa, & Cerita</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #0F766E;
            --color-on-primary: #FFFFFF;
            --color-accent: #F59E0B;
            --color-background: #FAFAF9;
            --color-foreground: #0F172A;
            --color-muted: #F1F5F9;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--color-background);
            color: var(--color-foreground);
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }
        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }

        .navbar { 
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }
        .navbar-brand { color: var(--color-primary) !important; font-weight: 800; letter-spacing: -0.5px; }
        .nav-link { font-weight: 500; color: #475569 !important; margin: 0 12px; transition: all 0.3s ease; font-size: 0.95rem; }
        .nav-link:hover { color: var(--color-primary) !important; transform: translateY(-1px); }
        .nav-link i { display: none; } /* Hide icons on main nav for cleaner look */
        .dropdown-menu .nav-link i, .dropdown-item i { display: inline-block; } /* Keep icons in dropdowns */
        
        .btn-custom { 
            background: var(--color-primary); 
            color: white !important; 
            border-radius: 30px; 
            padding: 8px 25px; 
            font-weight: 600; 
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.2);
        }
        .btn-custom:hover { 
            background: #115e59;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 118, 110, 0.3); 
        }
        .avatar-circle {
            width: 38px; height: 38px;
            background-color: #CCFBF1;
            color: #0F766E;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }
        .nav-item.dropdown:hover .avatar-circle {
            border-color: #0F766E;
        }
        footer { background: #0F172A; color: white; border-top: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body>
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="/">
                Nusa Go Explorer<span style="color: var(--color-accent);">.</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1 text-nowrap" href="/">
                            <i class="fa-solid fa-house"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1 text-nowrap" href="{{ route('destinasi') }}">
                            <i class="fa-solid fa-location-dot"></i> Destinasi
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1 text-nowrap" href="{{ route('kuliner') }}">
                            <i class="fa-solid fa-utensils"></i> Kuliner
                        </a>
                    </li>

                    @auth
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-1 text-nowrap" href="{{ route('maps.index') }}">
                                <i class="fa-solid fa-map-location-dot"></i> Peta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-1 text-nowrap" href="{{ route('virtual-camera.index') }}">
                                <i class="fa-solid fa-camera"></i> Virtual
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-1 text-nowrap" href="{{ route('chatbot.index') }}">
                                <i class="fa-solid fa-robot"></i> Chatbot
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-1 text-nowrap" href="{{ route('review.index') }}">
                                <i class="fa-solid fa-star"></i> Review
                            </a>
                        </li>

                        <li class="nav-item dropdown ms-lg-3 mt-3 mt-lg-0">
                            <a class="nav-link dropdown-toggle text-dark fw-bold d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" style="padding: 0;">
                                <div class="avatar-circle text-uppercase">{{ substr(Auth::user()->name, 0, 2) }}</div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 mt-2">
                                <li>
                                    <a class="dropdown-item fw-bold py-2" href="{{ route('dashboard') }}">
                                        <i class="fa-solid fa-chart-line me-2" style="display: inline-block; color: var(--color-primary);"></i>Dashboard
                                    </a>
                                </li>
                                @if(Auth::user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item fw-bold py-2" href="{{ route('admin.dashboard') }}">
                                            <i class="fa-solid fa-shield-halved me-2 text-danger" style="display: inline-block;"></i>Admin Panel
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                            <a class="btn btn-custom" href="{{ route('login') }}">Masuk / Daftar</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <main>
        @yield('content')
    </main>

    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <footer class="text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2026 Nusago Explorer. Pesona Indonesia di Ujung Jari.</p>
        </div>
    </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
