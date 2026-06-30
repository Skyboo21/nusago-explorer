<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kuliner;

Kuliner::truncate();

$data = [
    [
        'nama_kuliner' => 'Gudeg Yu Djum',
        'deskripsi_kuliner' => 'Salah satu legenda kuliner Yogyakarta yang menyajikan gudeg kering dengan krecek pedas dan ayam kampung empuk.',
        'daerah' => 'Yogyakarta',
        'kategori' => 'restoran',
        'harga_estimasi' => 35000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/e/ec/Gudeg_Yogyakarta.jpg',
        'latitude' => -7.7594,
        'longitude' => 110.3842,
        'rating' => 4.6,
        'is_halal' => true
    ],
    [
        'nama_kuliner' => 'Bebek Sinjay',
        'deskripsi_kuliner' => 'Warung bebek goreng paling fenomenal di Madura, terkenal dengan daging bebeknya yang empuk, bumbu kremes, dan sambal pencit (mangga muda) yang super pedas.',
        'daerah' => 'Bangkalan, Madura',
        'kategori' => 'restoran',
        'harga_estimasi' => 25000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/2/25/Bebek_Goreng.jpg',
        'latitude' => -7.0543,
        'longitude' => 112.7237,
        'rating' => 4.5,
        'is_halal' => true
    ],
    [
        'nama_kuliner' => 'Soto Ayam Ambengan Pak Sadi',
        'deskripsi_kuliner' => 'Soto ayam legendaris dari Surabaya dengan kuah kuning kental yang gurih dan tambahan koya yang melimpah.',
        'daerah' => 'Surabaya',
        'kategori' => 'restoran',
        'harga_estimasi' => 30000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/2/22/Soto_Ayam_Surabaya.jpg',
        'latitude' => -7.2625,
        'longitude' => 112.7483,
        'rating' => 4.7,
        'is_halal' => true
    ],
    [
        'nama_kuliner' => 'Pempek Candy',
        'deskripsi_kuliner' => 'Destinasi kuliner wajib saat ke Palembang. Menyajikan berbagai jenis pempek asli dengan cuko yang kental dan pedas.',
        'daerah' => 'Palembang',
        'kategori' => 'restoran',
        'harga_estimasi' => 40000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/1/18/Pempek_Palembang.JPG',
        'latitude' => -2.9761,
        'longitude' => 104.7554,
        'rating' => 4.6,
        'is_halal' => true
    ],
    [
        'nama_kuliner' => 'Sate Klathak Pak Pong',
        'deskripsi_kuliner' => 'Sate kambing unik khas Bantul yang ditusuk menggunakan jeruji besi sepeda agar matang sempurna hingga ke dalam.',
        'daerah' => 'Bantul, Yogyakarta',
        'kategori' => 'street_food',
        'harga_estimasi' => 25000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/f/ff/Sate_Klatak_Pak_Pong.jpg',
        'latitude' => -7.8696,
        'longitude' => 110.3844,
        'rating' => 4.8,
        'is_halal' => true
    ],
    [
        'nama_kuliner' => 'Nasi Liwet Keprabon',
        'deskripsi_kuliner' => 'Nasi liwet gurih khas Solo yang disajikan dengan suwiran ayam kampung, telur pindang, sayur labu siam, dan areh (santan kental).',
        'daerah' => 'Surakarta (Solo)',
        'kategori' => 'street_food',
        'harga_estimasi' => 20000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/8/87/Nasi_Liwet_Solo.jpg',
        'latitude' => -7.5684,
        'longitude' => 110.8242,
        'rating' => 4.5,
        'is_halal' => true
    ],
    [
        'nama_kuliner' => 'Ayam Betutu Men Tempeh',
        'deskripsi_kuliner' => 'Restoran Ayam Betutu legendaris di dekat pelabuhan Gilimanuk Bali. Terkenal dengan ayam super pedas dan bumbu rempah (base genep) khas Bali.',
        'daerah' => 'Gilimanuk, Bali',
        'kategori' => 'restoran',
        'harga_estimasi' => 50000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/f/f6/Ayam_Betutu_Gilimanuk.JPG',
        'latitude' => -8.1677,
        'longitude' => 114.4371,
        'rating' => 4.6,
        'is_halal' => true
    ],
    [
        'nama_kuliner' => 'Bika Ambon Zulaikha',
        'deskripsi_kuliner' => 'Oleh-oleh wajib khas Medan. Kue basah berwarna kuning dengan tekstur berongga yang harum aroma pandan dan daun jeruk.',
        'daerah' => 'Medan',
        'kategori' => 'kafe',
        'harga_estimasi' => 60000,
        'gambar_kuliner' => 'https://upload.wikimedia.org/wikipedia/commons/5/53/Bika_Ambon_Medan.jpg',
        'latitude' => -3.5852,
        'longitude' => 98.6756,
        'rating' => 4.7,
        'is_halal' => true
    ]
];

foreach ($data as $item) {
    Kuliner::create($item);
}

echo "Berhasil memasukkan " . count($data) . " destinasi kuliner nyata!";
