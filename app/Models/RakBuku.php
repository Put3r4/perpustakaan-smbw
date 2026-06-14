<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RakBuku extends Model
{
    protected $table = 'rak_buku';

    protected $fillable = [
        'kode_rak',
        'nama_rak',
        'lokasi',
    ];
    public function buku()
    {
        return $this->hasMany(Buku::class, 'rak_id');
    }
}
