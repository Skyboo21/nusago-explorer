<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusago Explorer - Jelajah, Rasa, & Cerita</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 (Core layout only, styling handled by Tailwind mostly) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome (Legacy compatibility) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false, // Prevents Tailwind from overriding Bootstrap defaults
            },
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        background: '#ffffff',
                        foreground: '#09090b',
                        muted: '#f4f4f5',
                        'muted-foreground': '#71717a',
                        primary: '#0F766E', // Nusago's teal
                        'primary-foreground': '#ffffff',
                        accent: '#F59E0B', // Nusago's yellow/orange
                        border: '#e4e4e7'
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js & Lucide Icons -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #FAFAF9;
            color: #0F172A;
            overflow-x: hidden;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        /* Glassmorphism Navbar */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(228, 228, 231, 0.6);
            transition: all 0.3s ease;
        }
        .glass-navbar.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.95) !important;
        }

        /* Navbar link styles */
        .nav-link-custom {
            font-weight: 500;
            color: #475569 !important;
            transition: all 0.2s ease;
            position: relative;
            font-size: 0.95rem;
        }
        .nav-link-custom:hover {
            color: #0F766E !important;
        }
        
        /* Interactive Avatar */
        .avatar-circle {
            width: 40px; height: 40px;
            background-color: #CCFBF1;
            color: #0F766E;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .avatar-circle:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
        }

        /* Hide FontAwesome icons in desktop nav if Lucide is preferred, but keep for legacy */
        @media (min-width: 992px) {
            .nav-link-custom > i { display: none; }
        }
    </style>
</head>
<body x-data="{ isScrolled: false }" @scroll.window="isScrolled = (window.pageYOffset > 20)">
    
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <!-- Main Navbar (Tailwind + Alpine) -->
    <nav :class="{ 'scrolled': isScrolled }" class="fixed top-0 inset-x-0 py-3 glass-navbar z-50" x-data="{ mobileMenuOpen: false }">
        <div class="container max-w-7xl mx-auto px-4 flex items-center justify-between">
            <!-- Brand / Logo -->
            <a href="/" class="font-heading flex items-center gap-2 group text-decoration-none">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6 shadow-sm">
                    <i data-lucide="compass" class="h-5 w-5 text-white"></i>
                </div>
                <span class="font-bold text-xl text-primary tracking-tight m-0">NusaGo Explorer<span class="text-accent">.</span></span>
            </a>
            
            <!-- Mobile Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden p-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                <i data-lucide="menu" class="h-6 w-6"></i>
            </button>
            
            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-1.5">
                <a href="/" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 text-decoration-none {{ request()->is('/') ? 'bg-teal-50 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">Beranda</a>
                <a href="{{ route('destinasi') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 text-decoration-none {{ request()->routeIs('destinasi') ? 'bg-teal-50 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">Destinasi</a>
                <a href="{{ route('kuliner') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 text-decoration-none {{ request()->routeIs('kuliner') ? 'bg-teal-50 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">Kuliner</a>

                @auth
                    <a href="{{ route('maps.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 text-decoration-none {{ request()->routeIs('maps.index') ? 'bg-teal-50 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">Peta</a>

                    <a href="{{ route('chatbot.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 text-decoration-none {{ request()->routeIs('chatbot.index') ? 'bg-teal-50 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">Chatbot</a>
                    <a href="{{ route('review.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 text-decoration-none {{ request()->routeIs('review.index') ? 'bg-teal-50 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">Review</a>

                    <!-- User Profile Dropdown -->
                    <div class="relative ml-2" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-2 p-0 border-0 bg-transparent">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-primary/20 shadow-sm transition-transform hover:scale-105">
                            @else
                                <div class="avatar-circle text-uppercase">{{ substr(Auth::user()->name, 0, 2) }}</div>
                            @endif
                        </button>
                        
                        <div x-show="dropdownOpen" x-transition.opacity style="display: none;" class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-lg border border-border py-2 overflow-hidden z-50">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-muted text-decoration-none">
                                <i data-lucide="layout-dashboard" class="h-4 w-4 text-primary"></i> Dashboard
                            </a>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-muted text-decoration-none">
                                    <i data-lucide="shield" class="h-4 w-4 text-red-500"></i> Admin Panel
                                </a>
                            @endif
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="ml-4 inline-flex items-center justify-center rounded-full bg-primary px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 transition-all active:scale-95 text-decoration-none">
                        Masuk / Daftar
                    </a>
                @endguest
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display: none;" x-transition class="lg:hidden bg-white border-t border-border shadow-lg absolute top-full left-0 w-full z-40">
            <div class="flex flex-col px-4 py-4 space-y-3">
                <a href="/" class="text-gray-700 font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="house" class="w-5 h-5"></i> Beranda</a>
                <a href="{{ route('destinasi') }}" class="text-gray-700 font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="location-dot" class="w-5 h-5"></i> Destinasi</a>
                <a href="{{ route('kuliner') }}" class="text-gray-700 font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="utensils" class="w-5 h-5"></i> Kuliner</a>
                
                @auth
                    <a href="{{ route('maps.index') }}" class="text-gray-700 font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="map-location-dot" class="w-5 h-5"></i> Peta</a>

                    <a href="{{ route('chatbot.index') }}" class="text-gray-700 font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="robot" class="w-5 h-5"></i> Chatbot</a>
                    <a href="{{ route('review.index') }}" class="text-gray-700 font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="star" class="w-5 h-5"></i> Review</a>
                    
                    <hr class="my-2 border-gray-100">
                    <a href="{{ route('dashboard') }}" class="text-primary font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-red-500 font-medium py-2 text-decoration-none flex items-center gap-2"><i data-lucide="shield" class="w-5 h-5"></i> Admin Panel</a>
                    @endif
                @endauth
                
                @guest
                    <a href="{{ route('login') }}" class="mt-2 inline-flex items-center justify-center rounded-full bg-primary px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 text-decoration-none w-full">
                        Masuk / Daftar
                    </a>
                @endguest
            </div>
        </div>
    </nav>
    @endif

    <main class="flex-1 {{ (!request()->routeIs('login') && !request()->routeIs('register')) ? 'pt-20 md:pt-24' : '' }}">
        @yield('content')
    </main>

    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <!-- Modern Footer -->
    <footer class="w-full border-t border-border bg-white mt-20">
        <div class="container max-w-7xl mx-auto px-4 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center space-x-3 group">
                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center shadow-sm">
                        <i data-lucide="compass" class="h-5 w-5 text-white"></i>
                    </div>
                    <span class="font-bold text-xl font-heading text-primary">NusaGo Explorer<span class="text-accent">.</span></span>
                </div>
                <div class="flex space-x-4">
                    <a href="https://instagram.com" target="_blank" class="w-10 h-10 rounded-full bg-muted flex items-center justify-center text-gray-500 hover:bg-[#E1306C] hover:text-white transition-colors shadow-sm text-decoration-none">
                        <i class="fa-brands fa-instagram fs-5"></i>
                    </a>
                    <a href="https://tiktok.com" target="_blank" class="w-10 h-10 rounded-full bg-muted flex items-center justify-center text-gray-500 hover:bg-black hover:text-white transition-colors shadow-sm text-decoration-none">
                        <i class="fa-brands fa-tiktok fs-5"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" class="w-10 h-10 rounded-full bg-muted flex items-center justify-center text-gray-500 hover:bg-[#FF0000] hover:text-white transition-colors shadow-sm text-decoration-none">
                        <i class="fa-brands fa-youtube fs-5"></i>
                    </a>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-border text-center text-sm text-gray-500 flex flex-col md:flex-row justify-between items-center gap-4">
                <p>&copy; {{ date('Y') }} Nusago Explorer. Pesona Indonesia di Ujung Jari.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-primary transition-colors no-underline">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-primary transition-colors no-underline">Syarat Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Lucide Icons globally
        lucide.createIcons();
    </script>
</body>
</html>
