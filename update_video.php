<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Menambahkan video untuk Taman Nasional Komodo
App\Models\Wisata::where('nama_wisata', 'like', '%Komodo%')
    ->update(['video_url' => 'https://www.youtube.com/embed/Z52P_1pD6n4']); // Contoh video wonderful indonesia / komodo

// Menambahkan video untuk Candi Borobudur
App\Models\Wisata::where('nama_wisata', 'like', '%Borobudur%')
    ->update(['video_url' => 'https://www.youtube.com/embed/s2R-OQ0T6p0']);

echo "Updated videos!";
