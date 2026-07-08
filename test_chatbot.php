<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$histories = App\Models\ChatHistory::where('user_id', 1)->latest()->take(10)->get()->reverse()->values();
$contents = [];
foreach ($histories as $h) {
    $contents[] = [
        'role'  => $h->role === 'assistant' ? 'model' : 'user',
        'parts' => [['text' => $h->message]],
    ];
}
while (count($contents) > 0 && $contents[0]['role'] === 'model') {
    array_shift($contents);
}
echo json_encode($contents, JSON_PRETTY_PRINT);
