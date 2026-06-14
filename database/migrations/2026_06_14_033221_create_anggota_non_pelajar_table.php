<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_non_pelajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('no_anggota', 20)->unique();
            $table->string('nik', 30);
            $table->string('nama_anggota', 100);
            $table->string('pekerjaan', 100);
            $table->string('ttl', 100);
            $table->text('alamat');
            $table->string('kode_pos', 10);
            $table->string('no_telp1', 20);
            $table->string('no_telp2', 20)->nullable();
            $table->date('tgl_daftar');
            $table->string('qr_anggota', 255)->nullable();
            $table->timestamps();

            $table->index('no_anggota');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_non_pelajar');
    }
};