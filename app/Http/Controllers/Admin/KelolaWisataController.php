<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelolaWisataController extends Controller
{
    private function getWisata()
    {
        return [
            ['id' => 1, 'nama' => 'Candi Borobudur', 'lokasi' => 'Magelang, Jawa Tengah', 'kategori' => 'Sejarah & Budaya', 'lat' => -7.6079, 'lng' => 110.2038, 'status' => 'aktif'],
            ['id' => 2, 'nama' => 'Pantai Kuta', 'lokasi' => 'Badung, Bali', 'kategori' => 'Pantai & Laut', 'lat' => -8.7184, 'lng' => 115.1686, 'status' => 'aktif'],
            ['id' => 3, 'nama' => 'Gunung Bromo', 'lokasi' => 'Probolinggo, Jawa Timur', 'kategori' => 'Alam & Petualangan', 'lat' => -7.9425, 'lng' => 112.9530, 'status' => 'aktif'],
            ['id' => 4, 'nama' => 'Danau Toba', 'lokasi' => 'Sumatera Utara', 'kategori' => 'Alam & Danau', 'lat' => 2.6845, 'lng' => 98.8756, 'status' => 'aktif'],
            ['id' => 5, 'nama' => 'Labuan Bajo', 'lokasi' => 'Manggarai Barat, NTT', 'kategori' => 'Pantai & Laut', 'lat' => -8.4961, 'lng' => 119.8707, 'status' => 'aktif'],
            ['id' => 6, 'nama' => 'Raja Ampat', 'lokasi' => 'Papua Barat', 'kategori' => 'Pantai & Laut', 'lat' => -0.2338, 'lng' => 130.5253, 'status' => 'aktif'],
        ];
    }

    public function index()
    {
        $wisata = $this->getWisata();
        return view('admin.wisata.index', compact('wisata'));
    }
}
