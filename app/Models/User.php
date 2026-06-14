<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'email_verified_at'];
    protected $hidden = ['password', 'remember_token'];

    public function rememberToken()
    {
        return $this->rememberToken();
    }

    public function anggotaPelajar(): HasOne {
        return $this->hasOne(AnggotaPelajar::class);
    }

    public function anggotaNonPelajar(): HasOne {
        return $this->hasOne(AnggotaNonPelajar::class);
    }

    public function petugas(): HasOne {
        return $this->hasOne(Petugas::class);
    }

    public function notifications(): HasMany {
        return $this->hasMany(Notification::class);
    }
}