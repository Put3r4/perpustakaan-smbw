<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            $table->integer('duration_seconds')->default(0); // Aturan bisnis minimal 60 detik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_views');
    }
};