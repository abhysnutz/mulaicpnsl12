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
        Schema::create('user_exams', function (Blueprint $table) {
            $table->id(); // ID unik untuk sesi ujian
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID pengguna yang mengikuti ujian
            $table->foreignId('tryout_id')->constrained('tryouts')->onDelete('cascade'); // ID tryout terkait
            $table->enum('status',['In Progress', 'Completed', 'Cancel']); // Status ujian (In Progress, Completed, Expired)
            $table->timestamp('start_time'); // Waktu mulai ujian
            $table->timestamp('end_time'); // Waktu berakhir ujian
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exams');
    }
};
