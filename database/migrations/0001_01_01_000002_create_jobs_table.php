<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Membuat tabel posts untuk feed media sosial palsu
     * - type: hoaks atau fakta
     * - content: teks postingan
     * - image: URL gambar (opsional)
     * - source: sumber postingan
     * - explanation: penjelasan mengapa hoaks/fakta (untuk edukasi)
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hoaks', 'fakta']);
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable(); // URL gambar
            $table->string('source')->nullable(); // Sumber berita
            $table->text('explanation'); // Penjelasan edukasi
            $table->integer('likes')->default(0);
            $table->integer('shares')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};