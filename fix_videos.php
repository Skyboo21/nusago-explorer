<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Fix Candi Borobudur
App\Models\Wisata::where('nama_wisata', 'like', '%Borobudur%')
    ->update([
        'gambar' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&q=80&w=1200'
    ]);

// Fix Pantai Klayar
App\Models\Wisata::where('nama_wisata', 'like', '%Klayar%')
    ->update([
        'gambar' => 'https://images.unsplash.com/photo-1587802496229-2708365851de?auto=format&fit=crop&q=80&w=1200',
        'video_url' => 'https://www.youtube.com/embed/uN5WqQYwzSg'
    ]);

echo "Updated missing photos and videos for Borobudur and Klayar!";
