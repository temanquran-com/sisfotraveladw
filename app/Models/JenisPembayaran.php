<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pembayaran',
        'keterangan',
    ];

     public function jenis_pembayaran(): HasMany
    {
        return $this->hasMany(UmrohPaket::class);
    }
}
