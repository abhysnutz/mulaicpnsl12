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
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // ID unik untuk soal
            $table->foreignId('tryout_id')->constrained('tryouts')->onDelete('cascade'); // ID tryout terkait
            $table->foreignId('topic_id')->constrained('question_topics')->onDelete('cascade'); // ID topik soal
            $table->text('question'); // Teks soal
            $table->text('explanation'); // Penjelasan jawaban
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
