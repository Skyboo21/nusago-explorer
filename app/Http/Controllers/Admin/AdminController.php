<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;
use App\Models\Guide;

class AdminController extends Controller
{
    public function index()
    {
        $totalPengunjung = User::where('role', 'user')->count();
        $totalReview     = Review::count();
        $totalGuide      = Guide::count();
        $pengunjungBaru  = User::where('role', 'user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPengunjung', 'totalReview', 'totalGuide', 'pengunjungBaru'
        ));
    }
}
