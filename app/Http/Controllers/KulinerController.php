<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    // Menampilkan daftar kuliner untuk user publik
    public function index()
    {
        $kuliners = Kuliner::latest()->get();
        
        // Ambil data wisata yang punya koordinat untuk dropdown "Sekitar Wisata"
        $destinasiKuliners = \App\Models\Wisata::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('kuliner.index', compact('kuliners', 'destinasiKuliners'));
    }

    // API Cari Terdekat (Digunakan oleh AJAX)
    public function cariTerdekat(Request $request)
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');

        if (!$lat || !$lon) {
            return response()->json([]);
        }

        // Rumus Haversine sederhana untuk mencari radius ~5km
        $kuliners = Kuliner::selectRaw("
            id, nama_kuliner, deskripsi_kuliner, daerah, harga_estimasi, 
            gambar_kuliner, latitude, longitude, rating, is_halal,
            ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(?) ) 
            + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", 
            [$lat, $lon, $lat])
        ->orderBy('distance')
        ->limit(20)
        ->get();

        return response()->json($kuliners);
    }

    // ✅ METHOD DETAIL KULINER PUBLIK
    public function showDetail($id)
    {
        $kuliner = Kuliner::findOrFail($id);
        return view('kuliner.detail', compact('kuliner'));
    }
}