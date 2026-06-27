<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaPengunjungController extends Controller
{
    public function index()
    {
        $pengunjung = User::where('role', 'user')->latest()->get();
        return view('admin.pengunjung.index', compact('pengunjung'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.pengunjung.index')->with('success', 'Pengunjung berhasil dihapus!');
    }
}
