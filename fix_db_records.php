<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

App\Models\Wisata::whereIn('id', [11, 12])->delete();

echo "Deleted duplicate Borobudur and Pantai Klayar test data!";
