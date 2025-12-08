<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketUmroh extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'durasi_hari',
        'harga_paket',
        'hotel_mekkah_id',
        'hotel_madinah_id',
        'maskapai_id',
        'tanggal_start',
        'tanggal_end',
        'include',
        'exclude',
        'syarat',
        'thumbnail',
        'is_active',
    ];

    protected $casts = [
        'harga_paket' => 'decimal:2',
        'durasi_hari' => 'integer',
    ];

      public function maskapai()
    {
        return $this->belongsTo(Maskapai::class);
    }

      public function hotel_mekah()
    {
        return $this->belongsTo(HotelMekah::class);
    }

      public function hotel_madinah()
    {
        return $this->belongsTo(HotelMadinah::class);
    }

    public function JadwalKeberangkatan()
    {
        return $this->hasMany(JadwalKeberangkatan::class, 'paket_umroh_id');
    }

      public function bookings()
    {
        return $this->hasMany(Booking::class, 'paket_umroh_id');
    }

    // Helper
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }
}
