<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$destinasi = [
    ['nama' => 'Borobudur', 'lat' => -7.6079, 'lng' => 110.2038],
    ['nama' => 'Kuta', 'lat' => -8.7184, 'lng' => 115.1686],
    ['nama' => 'Bromo', 'lat' => -7.9425, 'lng' => 112.9530],
    ['nama' => 'Toba', 'lat' => 2.6845, 'lng' => 98.8756],
    ['nama' => 'Bajo', 'lat' => -8.4961, 'lng' => 119.8707],
    ['nama' => 'Ampat', 'lat' => -0.2338, 'lng' => 130.5253],
    ['nama' => 'Komodo', 'lat' => -8.5401, 'lng' => 119.4897],
    ['nama' => 'Rebo', 'lat' => -8.7690, 'lng' => 120.2863],
    ['nama' => 'Toraja', 'lat' => -3.0033, 'lng' => 119.8665],
    ['nama' => 'Derawan', 'lat' => 2.2858, 'lng' => 118.2435],
    ['nama' => 'Ijen', 'lat' => -8.0583, 'lng' => 114.2422],
    ['nama' => 'Penida', 'lat' => -8.7278, 'lng' => 115.5444]
];

foreach ($destinasi as $d) {
    App\Models\Wisata::where('nama_wisata', 'like', '%' . $d['nama'] . '%')
        ->update(['lat' => $d['lat'], 'lng' => $d['lng']]);
}
echo "Updated locations!";
