<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari method enkapsulasi
        $userProfile = $this->getUserProfile();
        $userStats = $this->getUserStatistics();
        $recentActivities = $this->getRecentActivities();
        $quickAccess = $this->getQuickAccessMenu();

        return view('dashboard', compact('userProfile', 'userStats', 'recentActivities', 'quickAccess'));
    }

    // --- ENKAPSULASI DATA ---

    // 1. Data Profil Dinamis Sesuai User Login
    private function getUserProfile()
    {
        // Mengambil seluruh data pengguna yang sedang login dari database
        $user = Auth::user();

        return [
            'nama' => $user->name,
            'email' => $user->email,
            // Format tanggal bergabung menjadi "Bulan Tahun", jika null tampilkan "Baru bergabung"
            'bergabung' => $user->created_at ? $user->created_at->format('F Y') : 'Baru bergabung',
            
            // Catatan: Asal dan Bio menggunakan teks default karena tabel 'users' 
            // bawaan Laravel belum memiliki kolom 'asal' dan 'bio'.
            'asal' => 'Penjelajah Nusantara',
            'bio' => 'Siap mencari destinasi wisata tersembunyi dan kuliner otentik.',
            
            // Membuat URL avatar otomatis menyesuaikan inisial nama pengguna yang login
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=e3342f&color=fff&size=128'
        ];
    }

    // 2. Data Statistik
    private function getUserStatistics()
    {
        return [
            'total_poin' => 1250,
            'lokasi_dikunjungi' => 14,
            'level' => 'Explorer Muda'
        ];
    }

    // 3. Log Aktivitas
    private function getRecentActivities()
    {
        return [
            (object)['deskripsi' => 'Mengunjungi Candi Borobudur', 'waktu' => '2 jam yang lalu'],
            (object)['deskripsi' => 'Mendapatkan Badge "Penjelajah Sejarah"', 'waktu' => '1 hari yang lalu'],
            (object)['deskripsi' => 'Mencari rute ke Gunung Bromo', 'waktu' => '3 hari yang lalu'],
        ];
    }

    // 4. Menu Akses Cepat
    private function getQuickAccessMenu()
    {
        return [
            ['nama' => 'Peta Lokasi', 'url' => '#', 'icon' => 'fa-regular fa-map'],
            ['nama' => 'Misi Harian', 'url' => '#', 'icon' => 'fa-solid fa-bullseye'],
            ['nama' => 'Kuliner', 'url' => '#', 'icon' => 'fa-solid fa-utensils'],
            ['nama' => 'Pengaturan', 'url' => '#', 'icon' => 'fa-solid fa-gear'],
        ];
    }
}