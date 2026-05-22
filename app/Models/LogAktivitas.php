<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id', 'aktivitas', 'alamat_ip'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function catat($aktivitas)
    {
        self::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'alamat_ip' => request()->ip()
        ]);
    }
}
