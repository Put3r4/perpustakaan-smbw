<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('kode_petugas', 20)->unique();
            $table->string('nama_petugas', 100);
            $table->string('jabatan', 50);
            $table->string('foto', 255)->nullable();
            $table->string('no_telp', 20);
            $table->timestamps();

            $table->index('kode_petugas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};