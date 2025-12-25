<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKeberangkatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_umroh_id',
        'tour_leader_id',
        'muthawif_id',
        'maskapai_id',
        'bandara_id',
        'tanggal_keberangkatan',
        'tanggal_kembali',
        'jam_keberangkatan',
        'quota',
        'sisa_quota',
        'status',
    ];


    protected $casts = [
        'tanggal_keberangkatan' => 'date',
        'tanggal_kembali' => 'date',
        'jam_keberangkatan' => 'string',
        'quota' => 'integer',
        'sisa_quota' => 'integer',
    ];

    public function paketUmroh()
    {
        return $this->belongsTo(PaketUmroh::class, 'paket_umroh_id');
    }

    public function bandara()
    {
        return $this->belongsTo(Bandara::class, 'bandara_id');
    }

    public function tourLeader()
    {
        return $this->belongsTo(TourLeader::class, 'tour_leader_id');
    }

    public function muthawif()
    {
        return $this->belongsTo(Muthawif::class, 'muthawif_id');
    }

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class, 'maskapai_id');
    }

     public function bookings()
    {
        return $this->hasMany(Booking::class, 'jadwal_keberangkatan_id');
    }

       public function getAvailableQuotaAttribute()
    {
        return $this->quota - $this->bookings()
            ->whereNotIn('status', ['canceled', 'draft'])
            ->count();
    }
}
