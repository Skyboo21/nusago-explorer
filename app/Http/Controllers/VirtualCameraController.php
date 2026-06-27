<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VirtualCameraController extends Controller
{
    private function getDestinasi()
    {
        return [
            [
                'nama'      => 'Candi Borobudur',
                'lokasi'    => 'Magelang, Jawa Tengah',
                'lat'       => -7.6079,
                'lng'       => 110.2038,
                'deskripsi' => 'Candi Buddha terbesar di dunia, warisan budaya UNESCO.',
                'kategori'  => 'Sejarah & Budaya',
                'foto'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Borobudur_ship.jpg/640px-Borobudur_ship.jpg',
            ],
            [
                'nama'      => 'Pantai Kuta',
                'lokasi'    => 'Badung, Bali',
                'lat'       => -8.7184,
                'lng'       => 115.1686,
                'deskripsi' => 'Pantai ikonik Bali dengan sunset yang memukau.',
                'kategori'  => 'Pantai & Laut',
                'foto'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Kuta_beach_bali.jpg/640px-Kuta_beach_bali.jpg',
            ],
            [
                'nama'      => 'Gunung Bromo',
                'lokasi'    => 'Probolinggo, Jawa Timur',
                'lat'       => -7.9425,
                'lng'       => 112.9530,
                'deskripsi' => 'Gunung berapi aktif dengan pemandangan lautan pasir yang eksotis.',
                'kategori'  => 'Alam & Petualangan',
                'foto'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/74/Mount_Bromo_at_Sunrise%2C_Aug_2009.jpg/640px-Mount_Bromo_at_Sunrise%2C_Aug_2009.jpg',
            ],
            [
                'nama'      => 'Danau Toba',
                'lokasi'    => 'Sumatera Utara',
                'lat'       => 2.6845,
                'lng'       => 98.8756,
                'deskripsi' => 'Danau vulkanik terbesar di dunia dengan Pulau Samosir di tengahnya.',
                'kategori'  => 'Alam & Danau',
                'foto'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Lake_Toba_from_above.jpg/640px-Lake_Toba_from_above.jpg',
            ],
            [
                'nama'      => 'Labuan Bajo',
                'lokasi'    => 'Manggarai Barat, NTT',
                'lat'       => -8.4961,
                'lng'       => 119.8707,
                'deskripsi' => 'Surga bawah laut dengan habitat Komodo dan perairan biru jernih.',
                'kategori'  => 'Pantai & Laut',
                'foto'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/52/Labuan_Bajo_harbour.jpg/640px-Labuan_Bajo_harbour.jpg',
            ],
            [
                'nama'      => 'Raja Ampat',
                'lokasi'    => 'Papua Barat',
                'lat'       => -0.2338,
                'lng'       => 130.5253,
                'deskripsi' => 'Surga bawah laut dengan keanekaragaman hayati laut tertinggi di dunia.',
                'kategori'  => 'Pantai & Laut',
                'foto'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Raja_Ampat_Islands.jpg/640px-Raja_Ampat_Islands.jpg',
            ],
        ];
    }

    public function index()
    {
        $destinasi = $this->getDestinasi();
        $kategori  = array_unique(array_column($destinasi, 'kategori'));
        return view('virtual-camera.index', compact('destinasi', 'kategori'));
    }

    public function show(Request $request)
    {
        $destinasi = $this->getDestinasi();
        $nama      = $request->query('nama');
        $selected  = collect($destinasi)->firstWhere('nama', $nama);

        if (!$selected) {
            return redirect()->route('virtual-camera.index');
        }

        return view('virtual-camera.show', compact('selected', 'destinasi'));
    }
}
