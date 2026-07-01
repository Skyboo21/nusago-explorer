<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wisata;
use App\Models\Kuliner;
use App\Models\Guide;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $kategori = $request->input('kategori', 'all');

        $wisatas = collect();
        $kuliners = collect();
        $guides = collect();

        // Pencarian Wisata
        if ($kategori === 'all' || $kategori === 'wisata') {
            $wisataQuery = Wisata::query();
            if (!empty($query)) {
                $wisataQuery->where('nama_wisata', 'like', "%{$query}%")
                            ->orWhere('lokasi', 'like', "%{$query}%")
                            ->orWhere('alamat', 'like', "%{$query}%");
            }
            $wisatas = $wisataQuery->get();
        }

        // Pencarian Kuliner
        if ($kategori === 'all' || $kategori === 'kuliner') {
            $kulinerQuery = Kuliner::query();
            if (!empty($query)) {
                $kulinerQuery->where('nama_kuliner', 'like', "%{$query}%")
                             ->orWhere('daerah', 'like', "%{$query}%")
                             ->orWhere('deskripsi_kuliner', 'like', "%{$query}%");
            }
            $kuliners = $kulinerQuery->get();
        }

        // Pencarian Pemandu
        if ($kategori === 'all' || $kategori === 'pemandu') {
            $guideQuery = Guide::where('status', 'aktif');
            if (!empty($query)) {
                $guideQuery->where(function($q) use ($query) {
                    $q->where('nama', 'like', "%{$query}%")
                      ->orWhere('spesialisasi', 'like', "%{$query}%")
                      ->orWhere('deskripsi', 'like', "%{$query}%");
                });
            }
            $guides = $guideQuery->get();
        }

        return view('search-results', compact('wisatas', 'kuliners', 'guides', 'query', 'kategori'));
    }
}
