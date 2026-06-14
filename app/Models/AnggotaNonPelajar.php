<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AnggotaNonPelajar extends Model
{
    use HasFactory;

    protected $table = 'anggota_non_pelajar';

    protected $fillable = [
        'user_id',
        'no_anggota',
        'nik',
        'nama_anggota',
        'pekerjaan',
        'ttl',
        'alamat',
        'kode_pos',
        'no_telp1',
        'no_telp2',
        'tgl_daftar',
    ];

    protected function casts(): array
    {
        return [
            'tgl_daftar' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiNonPelajar::class, 'no_anggota_np');
    }

    public function visitorLogs(): MorphMany
    {
        return $this->morphMany(VisitorLog::class, 'member');
    }
}
