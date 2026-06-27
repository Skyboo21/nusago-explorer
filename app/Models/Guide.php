<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'bahasa',
        'spesialisasi',
        'harga_per_hari',
        'foto',
        'deskripsi',
        'status',
    ];
}
