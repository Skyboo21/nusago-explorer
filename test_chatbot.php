<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$histories = App\Models\ChatHistory::where('user_id', 1)
    ->latest()->take(10)->get()->reverse()->values();

$contents = [];
foreach ($histories as $h) {
    $contents[] = [
        'role'  => $h->role === 'assistant' ? 'model' : 'user',
        'parts' => [['text' => $h->message]],
    ];
}

$contents[] = [
    'role' => 'user',
    'parts' => [['text' => 'wisata di madiun']]
];

$apiKey = env('GEMINI_API_KEY');
$response = Illuminate\Support\Facades\Http::timeout(30)->post(
    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
    [
        'system_instruction' => [
            'parts' => [['text' => 'Kamu adalah asisten wisata Indonesia bernama NusaBot. Bantu wisatawan dengan informasi destinasi wisata, kuliner, budaya, dan rekomendasi perjalanan di Indonesia. Jawab dalam Bahasa Indonesia yang ramah dan informatif.']]
        ],
        'contents' => $contents,
    ]
);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
