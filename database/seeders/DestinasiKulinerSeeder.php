<?php

namespace Database\Seeders;

use App\Models\DestinasiKuliner;
use Illuminate\Database\Seeder;

class DestinasiKulinerSeeder extends Seeder
{
    public function run(): void
    {
        DestinasiKuliner::insert([
            ['nama_destinasi' => 'Candi Borobudur', 'latitude' => -7.6079, 'longitude' => 110.2038, 'kota' => 'Magelang'],
            ['nama_destinasi' => 'Pantai Kuta', 'latitude' => -8.7185, 'longitude' => 115.1686, 'kota' => 'Badung'],
            ['nama_destinasi' => 'Gunung Bromo', 'latitude' => -7.9425, 'longitude' => 112.9530, 'kota' => 'Probolinggo'],
            ['nama_destinasi' => 'Danau Toba', 'latitude' => 2.6845, 'longitude' => 98.8460, 'kota' => 'Sumatera Utara'],
            ['nama_destinasi' => 'Labuan Bajo', 'latitude' => -8.5060, 'longitude' => 119.8770, 'kota' => 'Manggarai Barat'],
            ['nama_destinasi' => 'Raja Ampat', 'latitude' => -0.2333, 'longitude' => 130.5167, 'kota' => 'Papua Barat'],
        ]);
    }
}