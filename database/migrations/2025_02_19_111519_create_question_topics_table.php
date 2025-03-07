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
        Schema::create('question_topics', function (Blueprint $table) {
            $table->id(); // ID unik
            $table->enum('category', ['TWK', 'TIU', 'TKP']); // Kategori soal
            $table->string('name'); // Nama materi/topik
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_topics');
    }
};
