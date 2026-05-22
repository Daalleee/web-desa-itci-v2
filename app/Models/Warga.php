<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'warga';

    protected $fillable = [
        'kartu_keluarga_id', 'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 
        'jenis_kelamin', 'agama', 'pendidikan', 'pekerjaan', 
        'status_perkawinan', 'hubungan_keluarga', 'nomor_telepon', 
        'alamat', 'foto', 'berkas_ktp', 'berkas_kk', 'status_warga'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class, 'warga_id');
    }

    public function bantuanSosial(): BelongsToMany
    {
        return $this->belongsToMany(BantuanSosial::class, 'penerima_bantuan', 'warga_id', 'bantuan_sosial_id')
                    ->withPivot('tanggal_terima')
                    ->withTimestamps();
    }

    public function arsipDokumen(): HasMany
    {
        return $this->hasMany(ArsipDokumen::class, 'warga_id');
    }
}
