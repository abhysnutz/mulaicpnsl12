<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');                  // 'login', 'login_failed', 'logout', 'start_tryout', dll
            $table->string('description')->nullable(); // teks ringkas buat ditampilkan ke admin
            $table->json('properties')->nullable();   // data tambahan fleksibel per jenis aktivitas
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['user_id', 'created_at']);
            $table->index('type');
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};