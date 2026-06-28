<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = env('GEMINI_API_KEY');
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 5,  // 5 Seconds
    )
));
$res = @file_get_contents('https://generativelanguage.googleapis.com/v1beta/models?key='.$apiKey, false, $ctx);
if ($res === false) {
    echo "Timeout or Error!\n";
} else {
    $data = json_decode($res, true);
    foreach ($data['models'] as $m) {
        if (strpos($m['name'], 'flash') !== false) {
            echo $m['name'] . "\n";
        }
    }
}
