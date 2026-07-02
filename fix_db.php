<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Memperbaiki tabel users di TiDB...\n";
    
    // Create new table with AUTO_INCREMENT
    DB::statement("
        CREATE TABLE IF NOT EXISTS users_new (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            email_verified_at timestamp NULL DEFAULT NULL,
            password varchar(255) NOT NULL,
            role varchar(255) NOT NULL DEFAULT 'user',
            remember_token varchar(100) NULL DEFAULT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY users_email_unique (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Copy data
    DB::statement("INSERT INTO users_new SELECT * FROM users;");
    
    // Replace old table
    DB::statement("DROP TABLE users;");
    DB::statement("RENAME TABLE users_new TO users;");

    echo "Berhasil! Tabel users sekarang sudah memiliki AUTO_INCREMENT.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
