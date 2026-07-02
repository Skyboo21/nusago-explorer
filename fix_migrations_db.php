<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Memperbaiki tabel migrations di TiDB...\n";
    
    // Create new table with AUTO_INCREMENT
    DB::statement("
        CREATE TABLE IF NOT EXISTS migrations_new (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `batch` int NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Copy data
    DB::statement("INSERT INTO migrations_new SELECT * FROM migrations;");
    
    // Replace old table
    DB::statement("DROP TABLE migrations;");
    DB::statement("RENAME TABLE migrations_new TO migrations;");

    // Also insert the missing record for the avatar migration since it crashed before saving
    // Check if the record already exists first
    $exists = DB::table('migrations')->where('migration', '2026_07_02_135126_add_avatar_to_users_table')->exists();
    if (!$exists) {
        $batch = DB::table('migrations')->max('batch') ?? 1;
        DB::table('migrations')->insert([
            'migration' => '2026_07_02_135126_add_avatar_to_users_table',
            'batch' => $batch + 1
        ]);
        echo "Menambahkan record migration avatar yang tertinggal.\n";
    }

    echo "Berhasil! Tabel migrations sekarang sudah memiliki AUTO_INCREMENT.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
