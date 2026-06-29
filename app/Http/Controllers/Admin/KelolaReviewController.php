<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class KelolaReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('user')->latest();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('wisata_nama', 'like', '%' . $request->search . '%')
                  ->orWhere('wisata_lokasi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }
        
        $reviews = $query->paginate(10);
        return view('admin.review.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->route('admin.review.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
