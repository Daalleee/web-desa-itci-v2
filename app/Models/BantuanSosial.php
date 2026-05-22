<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BantuanSosial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bantuan_sosial';

    protected $fillable = [
        'nama_program', 'keterangan', 'nominal', 'tanggal_penyaluran'
    ];

    protected $casts = [
        'tanggal_penyaluran' => 'date',
    ];

    public function warga(): BelongsToMany
    {
        return $this->belongsToMany(Warga::class, 'penerima_bantuan', 'bantuan_sosial_id', 'warga_id')
                    ->withPivot('tanggal_terima')
                    ->withTimestamps();
    }
}
