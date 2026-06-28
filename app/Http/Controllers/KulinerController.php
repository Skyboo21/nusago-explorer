<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use App\Models\DestinasiKuliner; // <-- Import Model Baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KulinerController extends Controller
{
    public function index()
    {
        $kuliners = Kuliner::all(); 
        
        // Ambil semua destinasi untuk dropdown "Sekitar Wisata"
        $destinasiKuliners = DestinasiKuliner::whereNotNull('latitude')
                                             ->whereNotNull('longitude')
                                             ->get(); 

        return view('kuliner.index', compact('kuliners', 'destinasiKuliners'));
    }

    public function cariTerdekat(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        $userLat = (float) $request->input('lat');
        $userLon = (float) $request->input('lon');
        
        // Radius dinamis: 50km untuk pencarian sekitar wisata, 20km untuk GPS user
        // Kita pakai 50km sebagai default biar aman mencakup area wisata yang luas
        $radiusMeter = 50000; 

        // 1. DATA LOKAL (DENGAN FILTER JARAK AMAN)
        $dataLokal = Kuliner::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($item) use ($userLat, $userLon) {
                $dist = sqrt(
                    pow((float)$item->latitude - $userLat, 2) + 
                    pow((float)$item->longitude - $userLon, 2)
                ) * 111000; 
                
                return [
                    'type' => 'node',
                    'id' => 'local_' . $item->id,
                    'lat' => (float)$item->latitude,
                    'lon' => (float)$item->longitude,
                    'distance' => $dist,
                    'tags' => [
                        'name' => $item->nama_kuliner,
                        'description' => $item->deskripsi_kuliner ?? 'Kuliner lezat khas daerah.',
                        'region' => $item->daerah ?? 'Lokal',
                        'price' => (int)$item->harga_estimasi ?? 0,
                        'image' => $item->gambar_kuliner,
                        'rating' => (float)$item->rating ?? 4.0,
                        'is_halal' => $item->is_halal ? 'yes' : 'no',
                        'source' => 'local_db'
                    ]
                ];
            })
            ->filter(fn($item) => $item['distance'] <= $radiusMeter)
            ->values()
            ->toArray();

        // 2. OVERPASS API DENGAN FALLBACK AMAN
        $overpassQuery = "[out:json];node(around:{$radiusMeter},{$userLat},{$userLon})['amenity'~'restaurant|cafe|fast_food|food_court'];out 15;";
        
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'NusagoExplorer/1.0',
                'Accept' => 'application/json'
            ])->timeout(15)->get('https://overpass-api.de/api/interpreter', [
                'data' => $overpassQuery
            ]);

            if ($response->successful()) {
                $elements = $response->json()['elements'] ?? [];
                
                foreach ($elements as &$el) {
                    $tags = $el['tags'] ?? [];
                    
                    // SEMUA FIELD OPSIONAL DIJAMIN ADA NILAINYA
                    $el['tags']['name'] = $tags['name'] ?? 'Warung Lokal';
                    $el['tags']['image'] = !empty($tags['image']) ? $tags['image'] : 
                        'https://loremflickr.com/400x300/food,restaurant?random=' . ($el['id'] ?? rand());
                    $el['tags']['description'] = $tags['description'] ?? $tags['note'] ?? 'Tempat makan populer di sekitar Anda.';
                    $el['tags']['region'] = $tags['addr:city'] ?? $tags['addr:suburb'] ?? 'Sekitar Anda';
                    $el['tags']['rating'] = $tags['stars'] ?? 4.0;
                    
                    // FIX UTAMA: PAKAI ?? BIAR NGGAK ERROR UNDEFINED KEY
                    $el['tags']['is_halal'] = ($tags['diet:halal'] ?? null) === 'yes' ? 'yes' : 'no';
                    
                    preg_match('/\d+/', $tags['price_range'] ?? $tags['price'] ?? '0', $matches);
                    $el['tags']['price'] = isset($matches[0]) ? (int)$matches[0] * 1000 : 0;
                    $el['tags']['source'] = 'overpass_api';
                }
                
                $combinedData = array_merge($dataLokal, $elements);
            } else {
                Log::warning('Overpass Failed', ['status' => $response->status()]);
                $combinedData = $dataLokal;
            }
        } catch (\Exception $e) {
            Log::error('Overpass Exception', ['message' => $e->getMessage()]);
            $combinedData = $dataLokal;
        }

        // 3. SORTING BERDASARKAN JARAK
        usort($combinedData, function ($a, $b) {
            return ($a['distance'] ?? 999999) <=> ($b['distance'] ?? 999999);
        });

        return response()->json($combinedData);
    }
}