<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramPromo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_promo',
        'benefit_value',
        'status',
        'deskripsi',
    ];

     public function program_promo(): HasMany
    {
        return $this->hasMany(UmrohPaket::class);
    }
}
