<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = env('GEMINI_API_KEY');
$response = Illuminate\Support\Facades\Http::timeout(30)->post(
    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
    [
        'system_instruction' => [
            'parts' => [['text' => 'Kamu adalah asisten wisata Indonesia.']]
        ],
        'contents' => [
            ['role' => 'user', 'parts' => [['text' => 'Halo']]]
        ],
    ]
);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
