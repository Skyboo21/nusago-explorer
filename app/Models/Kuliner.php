<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel baru di migration
    protected $table = 'kuliner'; 

    protected $fillable = [
        'nama_kuliner',
        'deskripsi_kuliner',
        'daerah',
        'harga_estimasi',
        'gambar_kuliner',
        'latitude',
        'longitude',
        'rating',
        'jam_operasional',
        'link_maps',
        'is_halal',
        'wisata_id',
    ];
}