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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_exam_id')->constrained('user_exams')->onDelete('cascade');
            $table->integer('total_twk')->default(0);
            $table->integer('total_tiu')->default(0);
            $table->integer('total_tkp')->default(0);
            $table->integer('total_score')->default(0);
            $table->boolean('is_passed')->default(false); // Status kelulusan (lulus/tidak)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
