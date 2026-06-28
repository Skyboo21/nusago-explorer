<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    use HasFactory;

    // PENTING: Sesuaikan nama tabel di database
    protected $table = 'kuliner';

    // Kolom yang boleh diisi massal (sesuai migration baru)
    protected $fillable = [
        'nama_kuliner',
        'deskripsi_kuliner',
        'daerah',
        'kategori',
        'harga_estimasi',
        'gambar_kuliner',
        'latitude',
        'longitude',
        'rating',
        'is_halal'
    ];

    // HAPUS relasi wisata() karena tabel sekarang mandiri
    // public function wisata() { ... } 
}