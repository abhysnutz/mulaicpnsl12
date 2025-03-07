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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id(); // ID unik langganan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID pengguna
            $table->enum('status', ['Active', 'Expired', 'Canceled']); // Status langganan
            $table->date('start_date'); // Tanggal mulai langganan
            $table->date('end_date'); // Tanggal berakhir langganan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
