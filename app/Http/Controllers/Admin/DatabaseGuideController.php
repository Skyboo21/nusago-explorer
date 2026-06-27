<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\Request;

class DatabaseGuideController extends Controller
{
    public function index()
    {
        $guides = Guide::latest()->get();
        return view('admin.guide.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.guide.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:guides',
            'telepon'       => 'required|string|max:20',
            'bahasa'        => 'required|string|max:255',
            'spesialisasi'  => 'required|string|max:255',
            'harga_per_hari'=> 'required|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        Guide::create($request->all());
        return redirect()->route('admin.guide.index')->with('success', 'Guide berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $guide = Guide::findOrFail($id);
        return view('admin.guide.edit', compact('guide'));
    }

    public function update(Request $request, $id)
    {
        $guide = Guide::findOrFail($id);
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:guides,email,' . $id,
            'telepon'       => 'required|string|max:20',
            'bahasa'        => 'required|string|max:255',
            'spesialisasi'  => 'required|string|max:255',
            'harga_per_hari'=> 'required|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $guide->update($request->all());
        return redirect()->route('admin.guide.index')->with('success', 'Guide berhasil diupdate!');
    }

    public function destroy($id)
    {
        Guide::findOrFail($id)->delete();
        return redirect()->route('admin.guide.index')->with('success', 'Guide berhasil dihapus!');
    }
}
