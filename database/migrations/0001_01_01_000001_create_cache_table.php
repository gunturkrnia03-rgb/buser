<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Membuat tabel users dengan kolom:
     * - name, email, password untuk auth
     * - school untuk data sekolah siswa
     * - level untuk leveling (pemula, menengah, mahir)
     * - total_score untuk akumulasi skor
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('school')->nullable(); // Nama sekolah
            $table->string('password');
            $table->enum('level', ['pemula', 'menengah', 'mahir'])->default('pemula');
            $table->integer('total_score')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};