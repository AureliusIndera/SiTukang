<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('aksi')
                  ->comment('Contoh: generate_gaji, tandai_dibayar, update_tarif');
            $table->string('model')->nullable()
                  ->comment('Nama model yang terpengaruh, contoh: Gaji');
            $table->unsignedBigInteger('model_id')->nullable()
                  ->comment('ID record yang terpengaruh');
            $table->json('detail')->nullable()
                  ->comment('Data tambahan dalam format JSON');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['user_id', 'aksi']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};