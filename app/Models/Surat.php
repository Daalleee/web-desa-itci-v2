<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat';

    protected $fillable = [
        'warga_id', 'nomor_surat', 'jenis_surat', 'keperluan', 
        'dibuat_oleh', 'ditandatangani_oleh', 'status', 'informasi_tambahan'
    ];

    protected $casts = [
        'informasi_tambahan' => 'array',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
