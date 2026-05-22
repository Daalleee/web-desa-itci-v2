<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'nomor_kk', 'kepala_keluarga', 'alamat', 'rt', 'rw'
    ];

    public function warga(): HasMany
    {
        return $this->hasMany(Warga::class, 'kartu_keluarga_id');
    }
}
