<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$videos = [
    ['nama' => 'Danau Toba', 'id' => 'uN5WqQYwzSg'],
    ['nama' => 'Tana Toraja', 'id' => 'uN5WqQYwzSg'],
    ['nama' => 'Kepulauan Derawan', 'id' => 'uN5WqQYwzSg'],
    ['nama' => 'Kawah Ijen', 'id' => 'uN5WqQYwzSg']
];

foreach ($videos as $v) {
    App\Models\Wisata::where('nama_wisata', 'like', '%' . $v['nama'] . '%')
        ->update(['video_url' => 'https://www.youtube.com/embed/' . $v['id']]);
}

echo "Updated problematic videos to default Wonderful Indonesia video!";
