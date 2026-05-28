<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Membuat tabel scores untuk menyimpan skor setiap sesi quiz
     * - user_id: siapa yang main
     * - total_score: skor total sesi tersebut
     * - correct_count: jumlah jawaban benar
     * - total_questions: total soal
     * - accuracy: persentase ketepatan
     */
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_score');
            $table->integer('correct_count');
            $table->integer('total_questions');
            $table->decimal('accuracy', 5, 2); // Persentase (0-100)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};