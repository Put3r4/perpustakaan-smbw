<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 30)->unique();
            $table->string('no_udc', 30)->nullable();
            $table->string('no_reg', 30)->nullable();
            $table->string('judul', 255);
            $table->string('penerbit', 100);
            $table->string('pengarang', 100);
            $table->year('tahun_terbit');
            $table->string('kota_terbit', 100);
            $table->string('bahasa', 50)->default('Indonesia');
            $table->string('edisi', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('isbn', 30)->nullable();
            $table->integer('jumlah_eksemplar')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->string('subjek_utama', 100)->nullable();
            $table->string('subjek_tambahan', 100)->nullable();
            $table->string('cover_buku', 255)->nullable();
            $table->integer('total_dilihat')->default(0);
            $table->integer('total_dipinjam')->default(0);
            $table->enum('status', ['tersedia', 'habis', 'rusak'])->default('tersedia');
            $table->timestamps();

            $table->index('kode_buku');
            $table->index('judul');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};