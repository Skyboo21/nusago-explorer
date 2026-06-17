<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Jangan lupa import Model yang dibutuhkan nanti, misalnya:
// use App\Models\Activity;
// use App\Models\Location;

class DashboardController extends Controller
{
    // Method utama yang akan merender halaman dashboard
    public function index()
    {
        // Mengambil data terenkapsulasi dari method lain
        $userStats = $this->getUserStatistics();
        $recentActivities = $this->getRecentActivities();
        $quickAccess = $this->getQuickAccessMenu();

        // Mengirim data ke antarmuka pengguna (View)
        return view('dashboard', compact('userStats', 'recentActivities', 'quickAccess'));
    }

    // Enkapsulasi 1: Menghitung Statistik
    private function getUserStatistics()
    {
        // Contoh data sementara (dummy) jika tabel database belum siap.
        // Nanti bisa diganti dengan query SQL atau Eloquent Laravel.
        return [
            'total_poin' => 1250,
            'lokasi_dikunjungi' => 14,
            'level' => 'Explorer Muda'
        ];
    }

    // Enkapsulasi 2: Mengambil Log Aktivitas
    private function getRecentActivities()
    {
        // Contoh data array (Nanti bisa pakai Activity::latest()->take(5)->get())
        return [
            (object)['deskripsi' => 'Mengunjungi Candi Borobudur', 'waktu' => '2 jam yang lalu'],
            (object)['deskripsi' => 'Mendapatkan Badge "Penjelajah Sejarah"', 'waktu' => '1 hari yang lalu'],
            (object)['deskripsi' => 'Mencari rute ke Gunung Bromo', 'waktu' => '3 hari yang lalu'],
        ];
    }

    // Enkapsulasi 3: Menu Akses Cepat
    private function getQuickAccessMenu()
    {
        return [
            ['nama' => 'Peta Lokasi', 'url' => '#', 'icon' => '🗺️'],
            ['nama' => 'Misi Harian', 'url' => '#', 'icon' => '🎯'],
            ['nama' => 'Profil Saya', 'url' => '#', 'icon' => '👤'],
        ];
    }
}