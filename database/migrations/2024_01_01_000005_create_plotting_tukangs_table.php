<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel jembatan Many-to-Many antara Tukang dan Proyek.
     * tarif_harian disimpan di sini agar bisa berbeda per proyek.
     */
    public function up(): void
    {
        Schema::create('plotting_tukangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tukang_id')
                  ->constrained('tukangs')
                  ->cascadeOnDelete();
            $table->foreignId('proyek_id')
                  ->constrained('proyeks')
                  ->cascadeOnDelete();
            $table->decimal('tarif_harian', 12, 2)
                  ->default(0)
                  ->comment('Tarif harian tukang khusus untuk proyek ini');
            $table->date('tanggal_masuk')->nullable()
                  ->comment('Tanggal tukang mulai bekerja di proyek ini');
            $table->date('tanggal_keluar')->nullable()
                  ->comment('Tanggal tukang selesai di proyek ini, null = masih aktif');
            $table->timestamps();

            // Satu tukang hanya bisa di-plot sekali per proyek
            $table->unique(['tukang_id', 'proyek_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plotting_tukangs');
    }
};
