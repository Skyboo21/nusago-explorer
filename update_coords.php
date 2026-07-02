<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$coords = [
    "Candi Borobudur" => ["lat" => -7.6078738, "lng" => 110.2037513],
    "Taman Nasional Komodo" => ["lat" => -8.527716, "lng" => 119.4833198],
    "Gunung Bromo" => ["lat" => -7.94249345, "lng" => 112.9530122],
    "Gunung Lawu" => ["lat" => -7.62749985, "lng" => 111.1941666],
    "Nusa Penida" => ["lat" => -8.745573, "lng" => 115.5376405],
    "Wae Rebo" => ["lat" => -8.7691132, "lng" => 120.2841863],
    "Telaga Sarangan" => ["lat" => -7.676527450000001, "lng" => 111.22722235],
    "Candi Prambanan" => ["lat" => -7.753116949999999, "lng" => 110.4928987],
    "Gunung Ciremai" => ["lat" => -6.89333315, "lng" => 108.4066666]
];

foreach ($coords as $name => $c) {
    DB::table('wisatas')->where('nama_wisata', $name)->update([
        'lat' => $c['lat'],
        'lng' => $c['lng']
    ]);
    echo "Updated $name\n";
}
