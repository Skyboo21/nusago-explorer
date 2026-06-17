<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nusa Go Explorer</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .grid { display: flex; gap: 20px; }
        .flex-1 { flex: 1; }
        .btn { display: inline-block; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; }
    </style>
</head>
<body>

    <h1>👋 Selamat Datang di Dashboard Nusa Go!</h1>

    <div class="grid">
        <div class="card flex-1">
            <h3>📊 Statistik Eksplorasimu</h3>
            <p><strong>Level:</strong> {{ $userStats['level'] }}</p>
            <p><strong>Total Poin:</strong> {{ $userStats['total_poin'] }}</p>
            <p><strong>Lokasi Dikunjungi:</strong> {{ $userStats['lokasi_dikunjungi'] }}</p>
        </div>

        <div class="card flex-1">
            <h3>⚡ Akses Cepat</h3>
            <div style="margin-top: 15px;">
                @foreach($quickAccess as $menu)
                    <a href="{{ $menu['url'] }}" class="btn">
                        {{ $menu['icon'] }} {{ $menu['nama'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <h3>🕒 Aktivitas Terbarumu</h3>
        <ul>
            @foreach($recentActivities as $aktivitas)
                <li style="margin-bottom: 10px;">
                    {{ $aktivitas->deskripsi }} 
                    <em style="color: gray; font-size: 0.9em;">- {{ $aktivitas->waktu }}</em>
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>