<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = Illuminate\Http\Request::create('/api/rekomendasi-wisata', 'POST', ['latitude' => -7.5560, 'longitude' => 111.6591, 'radius' => 100000]);
$response = app()->handle($req);
echo $response->getContent();
