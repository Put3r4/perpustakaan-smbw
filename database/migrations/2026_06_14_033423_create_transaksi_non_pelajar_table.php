<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_non_pelajar', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 50)->unique();
            $table->foreignId('no_anggota_np')->constrained('anggota_non_pelajar')->onDelete('restrict');
            $table->foreignId('buku_id')->constrained('buku')->onDelete('restrict');
            $table->foreignId('petugas_pinjam')->constrained('petugas')->onDelete('restrict');
            $table->foreignId('petugas_kembali')->nullable()->constrained('petugas')->onDelete('restrict');
            $table->string('qr_resi', 255)->nullable();
            $table->date('tgl_pinjam');
            $table->date('tgl_jatuh_tempo');
            $table->date('tgl_kembali')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->decimal('denda', 10, 2)->default(0.00);
            $table->enum('status_denda', ['belum_lunas', 'lunas'])->default('lunas');
            $table->timestamps();

            $table->index('kode_transaksi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_non_pelajar');
    }
};