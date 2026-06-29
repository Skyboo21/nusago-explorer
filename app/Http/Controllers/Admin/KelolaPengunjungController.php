<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaPengunjungController extends Controller
{
    public function index()
    {
        $pengunjung = User::latest()->get();
        return view('admin.pengunjung.index', compact('pengunjung'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pengunjung.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($validated);

        return redirect()->route('admin.pengunjung.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.pengunjung.index')->with('success', 'User berhasil dihapus!');
    }
}
