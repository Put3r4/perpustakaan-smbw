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
    protected $guarded = ['id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function transaksi(): HasMany {
        return $this->hasMany(TransaksiPelajar::class, 'no_anggota_p');
    }

    public function visitorLogs(): MorphMany {
        return $this->morphMany(VisitorLog::class, 'member');
    }
}