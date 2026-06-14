<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPelajar extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pelajar';
    protected $guarded = ['id'];

    public function anggota(): BelongsTo {
        return $this->belongsTo(AnggotaPelajar::class, 'no_anggota_p');
    }

    public function buku(): BelongsTo {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function petugasP(): BelongsTo {
        return $this->belongsTo(Petugas::class, 'petugas_pinjam');
    }

    public function petugasK(): BelongsTo {
        return $this->belongsTo(Petugas::class, 'petugas_kembali');
    }
}
