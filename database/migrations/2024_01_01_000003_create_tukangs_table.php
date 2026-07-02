<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tukangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('nama_tukang', 100);
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('skill', 100)->nullable()
                  ->comment('Contoh: Tukang Batu, Tukang Kayu, Tukang Las');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tukangs');
    }
};
