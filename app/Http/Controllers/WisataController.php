<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Wisata; // <-- WAJIB DITAMBAHKAN untuk konek ke database lokal tim

class WisataController extends Controller
{
    public function getRekomendasi(Request $request)
    {
        $lat = (float) $request->input('latitude');
        $lng = (float) $request->input('longitude');
        $radius = $request->input('radius', 100000); // 100km

        // 1. Ambil data lokal dari database sebagai fallback/gabungan
        $dataLokal = Wisata::all()->map(function ($item) use ($lat, $lng) {
            // Hitung jarak manual (Haversine kasar dalam meter)
            $dist = sqrt(
                pow((float)$item->lat - $lat, 2) + 
                pow((float)$item->lng - $lng, 2)
            ) * 111000; 
            
            return [
                'type' => 'node',
                'id' => 'local_' . $item->id,
                'lat' => (float)$item->lat,
                'lon' => (float)$item->lng,
                'distance' => $dist,
                'tags' => [
                    'name' => $item->nama_wisata,
                    'tourism' => 'attraction',
                    'source' => 'local_db'
                ]
            ];
        })
        ->filter(fn($item) => $item['distance'] <= $radius)
        ->values()
        ->toArray();

        // 2. Query Overpass API (cari wisata)
        $overpassQuery = "[out:json];node(around:{$radius},{$lat},{$lng})['tourism'~'attraction|museum|viewpoint|theme_park|zoo'];out 15;";
        
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'NusagoExplorer/1.0',
                'Accept' => 'application/json'
            ])->timeout(10)->get('https://overpass-api.de/api/interpreter', [
                'data' => $overpassQuery
            ]);

            if ($response->successful()) {
                $elements = $response->json()['elements'] ?? [];
                
                // Gabungkan data lokal dan Overpass
                $combined = array_merge($dataLokal, $elements);
                
                return response()->json([
                    'status' => 'success',
                    'data' => $combined
                ]);
            }

            // Jika Overpass gagal (misal 429 Too Many Requests), gunakan data lokal saja
            return response()->json([
                'status' => 'success', 
                'data' => $dataLokal,
                'message' => 'Overpass API failed, using local data.'
            ]);

        } catch (\Exception $e) {
            // Jika request timeout atau error jaringan, gunakan data lokal saja
            return response()->json([
                'status' => 'success', 
                'data' => $dataLokal,
                'message' => 'Fallback to local data due to timeout.'
            ]);
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
                                  ->limit(10)
                                  ->get();

        // Mengirim data ke tampilan destinasi.blade.php
        return view('destinasi', [
            'destinasiPopuler' => $destinasiPopuler
        ]);
    }
}