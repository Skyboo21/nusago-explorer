<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaWisataController extends Controller
{
    public function index()
    {
        $wisata = Wisata::latest()->get();
        return view('admin.wisata.index', compact('wisata'));
    }

    public function create()
    {
        return view('admin.wisata.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jumlah_pengunjung' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('wisata', 'public');
            $validated['gambar'] = $path;
        }

        Wisata::create($validated);

        return redirect()->route('admin.wisata.index')->with('success', 'Destinasi wisata berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('admin.wisata.edit', compact('wisata'));
    }

    public function update(Request $request, $id)
    {
        $wisata = Wisata::findOrFail($id);
        
        $validated = $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jumlah_pengunjung' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($wisata->gambar && Storage::disk('public')->exists($wisata->gambar)) {
                Storage::disk('public')->delete($wisata->gambar);
            }
            $path = $request->file('gambar')->store('wisata', 'public');
            $validated['gambar'] = $path;
        }

        $wisata->update($validated);

        return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $wisata = Wisata::findOrFail($id);
        
        // Hapus gambar terkait
        if ($wisata->gambar && Storage::disk('public')->exists($wisata->gambar)) {
            Storage::disk('public')->delete($wisata->gambar);
        }
        
        $wisata->delete();
        
        return redirect()->route('admin.wisata.index')->with('success', 'Destinasi wisata berhasil dihapus!');
    }
}
