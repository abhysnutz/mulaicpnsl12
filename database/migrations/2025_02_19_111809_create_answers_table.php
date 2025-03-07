<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // ID unik untuk jawaban
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade'); // ID soal terkait
            $table->char('option', 1); // Option Soal
            $table->string('answer'); // Opsi jawaban
            $table->integer('score'); // Skor untuk jawaban
            $table->timestamps(); // Kolom created_at dan updated_at
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
