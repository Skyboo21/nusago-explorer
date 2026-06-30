<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$replacements = [
    'Danau Toba' => [
        'nama' => 'Gunung Lawu',
        'deskripsi' => 'Gunung Lawu terletak di perbatasan Jawa Tengah dan Jawa Timur. Menawarkan pemandangan yang memukau dan jalur pendakian yang menantang.',
        'lokasi' => 'Perbatasan Jawa Tengah dan Jawa Timur',
        'lat' => -7.6275,
        'lng' => 111.1925,
        'video_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ' // guaranteed embeddable nature video
    ],
    'Tana Toraja' => [
        'nama' => 'Telaga Sarangan',
        'deskripsi' => 'Telaga Sarangan, juga dikenal sebagai Telaga Pasir, adalah telaga alami yang berada di lereng Gunung Lawu, Kabupaten Magetan.',
        'lokasi' => 'Magetan, Jawa Timur',
        'lat' => -7.6718,
        'lng' => 111.2201,
        'video_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ'
    ],
    'Kepulauan Derawan' => [
        'nama' => 'Candi Prambanan',
        'deskripsi' => 'Candi Prambanan adalah candi Hindu terbesar di Indonesia yang dibangun pada abad ke-9, didedikasikan untuk Trimurti.',
        'lokasi' => 'Sleman, Daerah Istimewa Yogyakarta',
        'lat' => -7.7520,
        'lng' => 110.4915,
        'video_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ'
    ],
    'Kawah Ijen' => [
        'nama' => 'Gunung Ciremai',
        'deskripsi' => 'Gunung Ciremai adalah gunung tertinggi di Jawa Barat. Gunung ini memiliki pesona kawah ganda dan kawasan hutan yang masih asri.',
        'lokasi' => 'Kuningan dan Majalengka, Jawa Barat',
        'lat' => -6.8922,
        'lng' => 108.4039,
        'video_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ'
    ]
];

foreach ($replacements as $oldName => $data) {
    App\Models\Wisata::where('nama_wisata', 'like', '%' . $oldName . '%')
        ->update([
            'nama_wisata' => $data['nama'],
            'deskripsi' => $data['deskripsi'],
            'lokasi' => $data['lokasi'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'video_url' => $data['video_url']
        ]);
}

echo "Destinations replaced!";
