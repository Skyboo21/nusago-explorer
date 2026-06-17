<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemandu extends Model
{
    use HasFactory;

    protected $fillable = ['wisata_id', 'nama_pemandu', 'kontak', 'harga_sewa'];

    // Relasi balik ke tabel wisatas
    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}