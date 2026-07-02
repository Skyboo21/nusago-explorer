<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    /**
     * Update data profil (nama, email, foto profil).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $mime = $file->getClientMimeType();
            
            // Simpan sebagai string base64 langsung ke database
            $user->avatar = 'data:' . $mime . ';base64,' . $base64;
        }

        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password pengguna dengan verifikasi password lama.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
        }

        // Update ke password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.settings')->with('status', 'Password berhasil diperbarui.');
    }
}
