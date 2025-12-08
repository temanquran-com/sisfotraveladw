<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maskapai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_maskapai',
        'kode_iata',
        'kode_icao',
        'logo',
    ];

    public function JadwalKeberangkatan()
    {
        return $this->hasMany(JadwalKeberangkatan::class);
    }
}
