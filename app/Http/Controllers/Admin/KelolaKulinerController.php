<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaKulinerController extends Controller
{
    public function index() {
        $kuliners = Kuliner::latest()->paginate(10);
        return view('admin.kuliner.index', compact('kuliners'));
    }

    public function create() {
        return view('admin.kuliner.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_kuliner' => 'required|string|max:255',
            'deskripsi_kuliner' => 'nullable|string',
            'daerah' => 'nullable|string|max:100',
            'harga_estimasi' => 'nullable|integer|min:0',
            'gambar_kuliner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jam_operasional' => 'nullable|string|max:255',
            'link_maps' => 'nullable|url|max:255',
            'is_halal' => 'boolean',
            'wisata_id' => 'nullable|exists:wisatas,id',
        ]);

        if ($request->hasFile('gambar_kuliner')) {
            $validated['gambar_kuliner'] = $request->file('gambar_kuliner')->store('kuliners');
        }
        $validated['is_halal'] = $request->has('is_halal');
        Kuliner::create($validated);

        return redirect()->route('admin.kuliner.index')->with('success', 'Data kuliner berhasil ditambahkan!');
    }

    public function edit($id) {
        $kuliner = Kuliner::findOrFail($id);
        return view('admin.kuliner.edit', compact('kuliner'));
    }

    public function update(Request $request, $id) {
        $kuliner = Kuliner::findOrFail($id);
        $validated = $request->validate([
            'nama_kuliner' => 'required|string|max:255',
            'deskripsi_kuliner' => 'nullable|string',
            'daerah' => 'nullable|string|max:100',
            'harga_estimasi' => 'nullable|integer|min:0',
            'gambar_kuliner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jam_operasional' => 'nullable|string|max:255',
            'link_maps' => 'nullable|url|max:255',
            'is_halal' => 'boolean',
            'wisata_id' => 'nullable|exists:wisatas,id',
        ]);

        if ($request->hasFile('gambar_kuliner')) {
            if ($kuliner->gambar_kuliner) Storage::delete($kuliner->gambar_kuliner);
            $validated['gambar_kuliner'] = $request->file('gambar_kuliner')->store('kuliners');
        } else {
            unset($validated['gambar_kuliner']);
        }
        $validated['is_halal'] = $request->has('is_halal');
        $kuliner->update($validated);

        return redirect()->route('admin.kuliner.index')->with('success', 'Data kuliner berhasil diperbarui!');
    }

    public function destroy($id) {
        $kuliner = Kuliner::findOrFail($id);
        if ($kuliner->gambar_kuliner) Storage::delete($kuliner->gambar_kuliner);
        $kuliner->delete();

        return redirect()->route('admin.kuliner.index')->with('success', 'Data kuliner berhasil dihapus!');
    }
}