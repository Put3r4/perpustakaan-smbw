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
    protected $guarded = ['id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function transaksi(): HasMany {
        return $this->hasMany(TransaksiNonPelajar::class, 'no_anggota_np');
    }

    public function visitorLogs(): MorphMany {
        return $this->morphMany(VisitorLog::class, 'member');
    }
}