<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (CRUD)
    protected $fillable = ['nama_wisata', 'deskripsi', 'lokasi', 'gambar', 'rating', 'jumlah_pengunjung', 'alamat', 'lat', 'lng', 'video_url'];

    // Relasi ke tabel pemandus
    public function pemandus()
    {
        return $this->hasMany(Pemandu::class);
    }

    // Relasi ke tabel kuliners
    public function kuliners()
    {
        return $this->hasMany(Kuliner::class);
    }
}