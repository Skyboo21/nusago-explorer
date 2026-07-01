<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$borobudur = App\Models\Wisata::where('nama_wisata', 'like', '%Borobudur%')->get()->toArray();
echo "Borobudur records:\n";
print_r($borobudur);

$klayar = App\Models\Wisata::where('nama_wisata', 'like', '%Klayar%')->orWhere('nama_wisata', 'like', '%Sarangan%')->get()->toArray();
echo "\nKlayar/Sarangan records:\n";
print_r($klayar);
