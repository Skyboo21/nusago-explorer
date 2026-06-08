<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    use HasFactory;

    protected $fillable = ['wisata_id', 'nama_kuliner', 'deskripsi_kuliner', 'harga_estimasi', 'gambar_kuliner'];

    // Relasi balik ke tabel wisatas
    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}