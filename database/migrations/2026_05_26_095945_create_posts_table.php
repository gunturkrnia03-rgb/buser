<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Membuat tabel quizzes untuk sistem quiz
     * - type: hoaks atau fakta (jawaban benar)
     * - question: pertanyaan/soal
     * - image: gambar soal (opsional)
     * - difficulty: tingkat kesulitan
     * - explanation: penjelasan setelah menjawab
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hoaks', 'fakta']);
            $table->string('question');
            $table->string('image')->nullable();
            $table->enum('difficulty', ['mudah', 'sedang', 'sulit'])->default('mudah');
            $table->integer('points')->default(10); // Poin berdasarkan kesulitan
            $table->text('explanation'); // Penjelasan edukasi
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};