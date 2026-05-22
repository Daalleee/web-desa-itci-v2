<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipDokumen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'arsip_dokumen';

    protected $fillable = [
        'warga_id', 'judul', 'kategori', 'jalur_file', 'keterangan'
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
