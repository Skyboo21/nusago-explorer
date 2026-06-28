<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Wisata;

if (!is_dir(public_path('img'))) {
    mkdir(public_path('img'), 0777, true);
}

$wisatas = Wisata::all();

$options = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: NusagoExplorerBot/1.0 (harizlazuardi01@gmail.com)\r\n"
    ]
];
$context = stream_context_create($options);

foreach ($wisatas as $wisata) {
    if (strpos($wisata->gambar, 'http') === 0) {
        $url = $wisata->gambar;
        $filename = md5($wisata->nama_wisata) . '.jpg';
        $filepath = public_path('img/' . $filename);
        
        echo "Downloading " . $wisata->nama_wisata . "...\n";
        
        $imageData = @file_get_contents($url, false, $context);
        if ($imageData) {
            file_put_contents($filepath, $imageData);
            $wisata->gambar = $filename;
            $wisata->save();
            echo "Success: " . $filename . "\n";
        } else {
            echo "Failed to download: " . $url . "\n";
        }
    }
}
echo "Done!\n";
