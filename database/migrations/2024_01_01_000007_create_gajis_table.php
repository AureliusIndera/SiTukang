<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel Gaji — rekap bulanan per tukang.
     * total_gaji = Σ (total_hadir_di_proyek_X * tarif_harian_di_proyek_X) semua proyek.
     */
    public function up(): void
    {
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tukang_id')
                  ->constrained('tukangs')
                  ->cascadeOnDelete();
            $table->tinyInteger('bulan')
                  ->comment('1 = Januari, 12 = Desember');
            $table->year('tahun');
            $table->integer('total_hari_kerja')
                  ->default(0)
                  ->comment('Total hari dengan status Hadir di bulan ini (semua proyek)');
            $table->decimal('total_gaji', 15, 2)
                  ->default(0)
                  ->comment('Hasil kalkulasi: Σ(hadir * tarif) per proyek');
            $table->enum('status_pembayaran', ['pending', 'dibayar'])
                  ->default('pending');
            $table->timestamp('dibayar_pada')->nullable()
                  ->comment('Timestamp saat status diubah menjadi dibayar');
            $table->foreignId('dibayar_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('Admin yang mengkonfirmasi pembayaran');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Satu tukang hanya punya 1 rekap gaji per bulan per tahun
            $table->unique(['tukang_id', 'bulan', 'tahun'], 'unique_gaji_bulanan');

            // Index untuk filter per periode
            $table->index(['bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
