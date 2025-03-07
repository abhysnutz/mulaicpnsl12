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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('province_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->date('birth')->nullable();
            $table->string('phone')->nullable();
            $table->string('major')->nullable();
            $table->text('address')->nullable();
            $table->enum('education', [
                'SD',
                'SMP',
                'SMA',
                'D1',
                'D2',
                'D3',
                'D4',
                'S1',
                'S2',
                'S3',
            ])->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on('provinces')->nullOnDelete();
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
