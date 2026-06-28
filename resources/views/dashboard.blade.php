<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nusa Go Explorer</title>
    
    <!-- Font dan Ikon -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-red: #e3342f;
            --primary-hover: #c82333;
            --primary-accent: #F59E0B;
            --bg-light: #f4f7f6;
            --text-dark: #2c3e50;
            --text-muted: #7f8c8d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            color: var(--text-dark);
        }

        /* Navbar Sederhana */
        .navbar {
            background: white;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            color: var(--primary-red);
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-section {
            margin-bottom: 30px;
        }

        .header-section h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header-section p {
            color: var(--text-muted);
            margin-top: 0;
        }

        /* Grid Layout */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 25px;
        }

        /* Card Styling */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
        }

        .card-title i {
            color: var(--primary-accent);
        }

        /* Styling Foto Profil */
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fffafa;
            box-shadow: 0 4px 10px rgba(227, 52, 47, 0.2);
            margin-bottom: 15px;
        }
        
        .profile-name { margin: 0; font-size: 1.3rem; font-weight: 700; color: var(--text-dark); }
        .profile-location { color: var(--text-muted); font-size: 0.9rem; margin-top: 5px; }
        .profile-detail { margin-bottom: 10px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;}
        .profile-detail strong { color: var(--text-dark); }

        /* Statistik Box */
        .stat-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fffafa;
            border-left: 4px solid var(--primary-accent);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-accent);
        }

        /* Tombol Akses Cepat */
        .quick-access-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-quick {
            background: white;
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .btn-quick i {
            font-size: 1.5rem;
            color: var(--primary-accent);
        }

        .btn-quick:hover {
            background: var(--primary-accent);
            color: white;
            border-color: var(--primary-accent);
        }

        .btn-quick:hover i {
            color: white;
        }

        /* List Aktivitas */
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            background: #fffafa;
            color: var(--primary-accent);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-details p {
            margin: 0;
            font-weight: 500;
        }

        .activity-details small {
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="navbar-brand" style="color: #0F766E; gap: 0;">
            Nusa Go Explorer<span style="color: var(--primary-accent);">.</span>
        </a>
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="/" style="text-decoration: none; color: var(--text-dark); font-weight: 600;">
                <i class="fa-solid fa-house"></i> Kembali ke Beranda
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" style="background: var(--primary-red); color: white; border: none; padding: 8px 20px; border-radius: 20px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="header-section">
            <!-- Menampilkan nama panggilan (kata pertama dari nama lengkap) -->
            <h1>Halo, {{ explode(' ', $userProfile['nama'])[0] }}! 👋</h1>
            <p>Selamat datang kembali di pusat komandomu. Siap untuk petualangan hari ini?</p>
        </div>

        <div class="grid">
            
            <!-- CARD 1: Profil Pengguna -->
            <div class="card">
                <div class="profile-header">
                    <img src="{{ $userProfile['avatar'] }}" alt="Profil" class="profile-img">
                    <h2 class="profile-name">{{ $userProfile['nama'] }}</h2>
                    <div class="profile-location">
                        <i class="fa-solid fa-location-dot" style="color: var(--primary-accent);"></i> {{ $userProfile['asal'] }}
                    </div>
                </div>
                <div>
                    <div class="profile-detail">
                        <i class="fa-regular fa-envelope" style="width: 20px; color: var(--text-muted); text-align: center;"></i> 
                        <span><strong>Email:</strong> {{ $userProfile['email'] }}</span>
                    </div>
                    <div class="profile-detail">
                        <i class="fa-regular fa-calendar-check" style="width: 20px; color: var(--text-muted); text-align: center;"></i> 
                        <span><strong>Bergabung:</strong> {{ $userProfile['bergabung'] }}</span>
                    </div>
                    <div style="margin-top: 15px; background: #f9f9f9; padding: 15px; border-radius: 8px; font-style: italic; color: #555; font-size: 0.95rem; line-height: 1.5;">
                        "{{ $userProfile['bio'] }}"
                    </div>
                </div>
            </div>

            <!-- CARD 2: Statistik -->
            <div class="card">
                <div class="card-title">
                    <i class="fa-solid fa-chart-pie"></i> Statistik Eksplorasi
                </div>
                <div class="stat-box">
                    <div>
                        <small>Level Saat Ini</small>
                        <div style="font-weight: 600;">{{ $userStats['level'] }}</div>
                    </div>
                    <i class="fa-solid fa-medal" style="color: #f1c40f; font-size: 1.5rem;"></i>
                </div>
                <div class="stat-box">
                    <div>
                        <small>Total Poin</small>
                        <div class="stat-value">{{ $userStats['total_poin'] }}</div>
                    </div>
                    <i class="fa-solid fa-star" style="color: var(--primary-accent); opacity: 0.2; font-size: 2rem;"></i>
                </div>
                <div class="stat-box">
                    <div>
                        <small>Lokasi Dikunjungi</small>
                        <div class="stat-value">{{ $userStats['lokasi_dikunjungi'] }}</div>
                    </div>
                    <i class="fa-solid fa-location-dot" style="color: var(--primary-accent); opacity: 0.2; font-size: 2rem;"></i>
                </div>
            </div>

            <!-- CARD 3: Akses Cepat -->
            <div class="card">
                <div class="card-title">
                    <i class="fa-solid fa-bolt"></i> Akses Cepat
                </div>
                <div class="quick-access-grid">
                    @foreach($quickAccess as $menu)
                    <a href="{{ $menu['url'] }}" class="btn-quick">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span>{{ $menu['nama'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Card Aktivitas Terbaru -->
        <div class="card">
            <div class="card-title">
                <i class="fa-regular fa-clock"></i> Aktivitas Terbarumu
            </div>
            <ul class="activity-list">
                @foreach($recentActivities as $aktivitas)
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div class="activity-details">
                            <p>{{ $aktivitas->deskripsi }}</p>
                            <small>{{ $aktivitas->waktu }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</body>
</html>