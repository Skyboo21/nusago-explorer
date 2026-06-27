<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->latest()->get();
        $myReviews = Review::where('user_id', Auth::id())->latest()->get();
        return view('review.index', compact('reviews', 'myReviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wisata_nama'   => 'required|string|max:255',
            'wisata_lokasi' => 'nullable|string|max:255',
            'rating'        => 'required|integer|min:1|max:5',
            'komentar'      => 'required|string|min:5',
        ]);

        Review::create([
            'user_id'       => Auth::id(),
            'wisata_nama'   => $request->wisata_nama,
            'wisata_lokasi' => $request->wisata_lokasi,
            'rating'        => $request->rating,
            'komentar'      => $request->komentar,
        ]);

        return redirect()->route('review.index')->with('success', 'Review berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $review->delete();
        return redirect()->route('review.index')->with('success', 'Review berhasil dihapus!');
    }
}
