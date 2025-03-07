<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['Tryout', 'Latihan TWK', 'Latihan TIU', 'Latihan TKP']);
            $table->enum('access_type', ['free','premium'])->default('free');
            $table->foreignId('tryout_source_id')->constrained('tryout_sources')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryouts');
    }
};
