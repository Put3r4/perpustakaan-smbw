<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'no_udc',
        'no_reg',
        'judul',
        'penerbit',
        'pengarang',
        'tahun_terbit',
        'kota_terbit',
        'bahasa',
        'edisi',
        'deskripsi',
        'isbn',
        'jumlah_eksemplar',
        'stok_tersedia',
        'subjek_utama',
        'subjek_tambahan',
        'cover_buku',
        'status',
    ];
}
