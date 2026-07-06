<?php
$pdo = new PDO('mysql:host=gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com;port=4000;dbname=nusago_explorer;sslmode=REQUIRED', '2vxJaQandS7dpCP.root', 'Siz85OkCr7bINy8r', [
    PDO::MYSQL_ATTR_SSL_CA => 'c:/Users/hariz/nusago-explorer/cacert.pem',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "Fetching old reviews...\n";
$stmt = $pdo->query('SELECT * FROM reviews');
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Dropping old reviews table...\n";
$pdo->exec('DROP TABLE reviews');

echo "Creating new reviews table with AUTO_INCREMENT...\n";
$createTableQuery = "
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `wisata_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wisata_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
$pdo->exec($createTableQuery);

echo "Inserting old reviews back...\n";
if (!empty($reviews)) {
    $insertStmt = $pdo->prepare('INSERT INTO reviews (id, user_id, wisata_nama, wisata_lokasi, rating, komentar, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    foreach ($reviews as $rev) {
        $insertStmt->execute([
            $rev['id'],
            $rev['user_id'],
            $rev['wisata_nama'],
            $rev['wisata_lokasi'],
            $rev['rating'],
            $rev['komentar'],
            $rev['created_at'],
            $rev['updated_at']
        ]);
    }
}

echo "Done!\n";
