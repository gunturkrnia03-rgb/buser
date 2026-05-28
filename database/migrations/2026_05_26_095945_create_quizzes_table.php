<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Membuat tabel answers untuk menyimpan jawaban user
     * - user_id: siapa yang menjawab
     * - quiz_id: quiz yang dijawab
     * - answer: jawaban user (hoaks/fakta)
     * - is_correct: apakah benar/salah
     * - time_spent: waktu yang dihabiskan (detik)
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->enum('answer', ['hoaks', 'fakta']);
            $table->boolean('is_correct');
            $table->integer('time_spent')->default(0); // dalam detik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};