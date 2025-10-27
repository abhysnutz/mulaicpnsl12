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
        Schema::create('question_tryout', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('tryout_id');
            $table->unsignedInteger('order')->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete();
            $table->foreign('tryout_id')->references('id')->on('tryouts')->cascadeOnDelete();
            $table->unique(['question_id', 'tryout_id']); // supaya tidak double attach
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_tryout');
    }
};
