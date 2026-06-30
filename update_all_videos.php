<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$videos = [
    ['nama' => 'Taman Nasional Komodo', 'id' => 'BHqNWkkMzI0'],
    ['nama' => 'Raja Ampat', 'id' => 'QvCOu0FZ6Dg'],
    ['nama' => 'Wae Rebo', 'id' => 'lw8vd7GfjvQ'],
    ['nama' => 'Candi Borobudur', 'id' => 'hKpSupcKBj0'],
    ['nama' => 'Nusa Penida', 'id' => 'd-AJkHuIQXY'],
    ['nama' => 'Gunung Bromo', 'id' => '1zoasRfKEdY'],
    ['nama' => 'Danau Toba', 'id' => 'Q9KjZ2fDDEo'],
    ['nama' => 'Tana Toraja', 'id' => '6yNbb6YkXf8'],
    ['nama' => 'Kepulauan Derawan', 'id' => 'Yg1gQyYp3H8'],
    ['nama' => 'Kawah Ijen', 'id' => 'J_jC8N3jOqQ']
];

// 1. Update spesifik tempat
foreach ($videos as $v) {
    App\Models\Wisata::where('nama_wisata', 'like', '%' . $v['nama'] . '%')
        ->update(['video_url' => 'https://www.youtube.com/embed/' . $v['id']]);
}

// 2. Set default buat wisata lain yang belum ada videonya (pakai video Wonderful Indonesia)
App\Models\Wisata::whereNull('video_url')
    ->update(['video_url' => 'https://www.youtube.com/embed/uN5WqQYwzSg']);

echo "All videos updated!\n";
