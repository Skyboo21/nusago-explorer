<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Wisata; // <-- WAJIB DITAMBAHKAN untuk konek ke database lokal tim

class WisataController extends Controller
{
    public function getRekomendasi(Request $request)
    {
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        // Query Overpass API (cari wisata radius 20km)
        $overpassQuery = "[out:json];node(around:20000,{$lat},{$lng})['tourism'~'attraction|museum|viewpoint|theme_park|zoo'];out 10;";
        
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'NusagoExplorer/1.0',
                'Accept' => 'application/json'
            ])->get('https://overpass-api.de/api/interpreter', [
                'data' => $overpassQuery
            ]);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $response->json()['elements']
                ]);
            }

            return response()->json([
                'status' => 'error', 
                'message' => 'Alasan: ' . $response->body()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // <-- FUNGSI BARU UNTUK MENAMPILKAN DETAIL -->
    public function showDetail(Request $request)
    {
        // 1. Tangkap nama wisata dari URL yang diklik user
        $namaPencarian = $request->query('nama');

        // 2. Cocokkan dengan database buatan tim (menggunakan operator LIKE)
        // Pastikan nama kolom di database kalian benar-benar bernama 'nama_wisata'
        $dataLokal = Wisata::where('nama_wisata', 'LIKE', '%' . $namaPencarian . '%')->first();

        // 3. Tampilkan ke file detail.blade.php
        return view('detail', [
            'namaDariApi' => $namaPencarian,
            'dataWisata' => $dataLokal
        ]);
    }

    // ... (Fungsi getRekomendasi dan showDetail biarkan saja) ...

    public function halamanDestinasi()
    {
        // Mengambil 6 data wisata terpopuler dari database
        // Asumsi: tabel kamu memiliki kolom 'rating' dan 'jumlah_pengunjung'
        $destinasiPopuler = Wisata::orderBy('rating', 'desc')
                                  ->orderBy('jumlah_pengunjung', 'desc')
                                  ->limit(6)
                                  ->get();

        // Mengirim data ke tampilan destinasi.blade.php
        return view('destinasi', [
            'destinasiPopuler' => $destinasiPopuler
        ]);
    }
}