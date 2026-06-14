<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('member_type'); // Menyimpan class model target (Polymorphic)
            $table->unsignedBigInteger('member_id'); // ID dari tabel anggota_pelajar atau anggota_non_pelajar
            $table->dateTime('checkin_at');
            $table->dateTime('checkout_at')->nullable();
            $table->integer('durasi_kunjungan')->nullable(); // Dalam satuan menit
            $table->timestamps();

            $table->index(['member_type', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};