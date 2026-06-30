<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$videos = [
    ['nama' => 'Gunung Lawu', 'id' => 'drEyYWPD5ng'],
    ['nama' => 'Telaga Sarangan', 'id' => '5Af-43kaFzM'],
    ['nama' => 'Candi Prambanan', 'id' => 'MhifUwbQj6o'],
    ['nama' => 'Gunung Ciremai', 'id' => 'N6gI5n4QYfM']
];

foreach ($videos as $v) {
    App\Models\Wisata::where('nama_wisata', 'like', '%' . $v['nama'] . '%')
        ->update(['video_url' => 'https://www.youtube.com/embed/' . $v['id']]);
}

echo "Video links updated for the 4 destinations!";
