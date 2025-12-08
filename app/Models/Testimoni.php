<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'star_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
