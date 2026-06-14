<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetugasShift extends Model
{
    use HasFactory;

    protected $table = 'petugas_shifts';
    protected $guarded = ['id'];

    public function petugas(): BelongsTo {
        return $this->belongsTo(Petugas::class);
    }
}