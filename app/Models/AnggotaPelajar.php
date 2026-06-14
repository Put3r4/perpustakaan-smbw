<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AnggotaPelajar extends Model
{
    use HasFactory;

    protected $table = 'anggota_pelajar';

    protected $fillable = [
        'user_id',
        'no_anggota',
        'nim_nis',
        'nama_anggota',
        'asal_sekolah',
        'tanggal_lahir',
        'alamat',
        'kode_pos',
        'no_telp1',
        'no_telp2',
        'tgl_daftar',
        'nama_ortu',
        'alamat_ortu',
        'no_telp_ortu',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tgl_daftar'    => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiPelajar::class, 'no_anggota_p');
    }

    public function visitorLogs(): MorphMany
    {
        return $this->morphMany(VisitorLog::class, 'member');
    }
}
