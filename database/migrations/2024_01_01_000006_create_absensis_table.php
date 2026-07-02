<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel Absensi.
     * mandor_id = audit trail: siapa mandor yang menginput absensi ini.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tukang_id')
                  ->constrained('tukangs')
                  ->cascadeOnDelete();
            $table->foreignId('proyek_id')
                  ->constrained('proyeks')
                  ->cascadeOnDelete();
            $table->foreignId('mandor_id')
                  ->constrained('mandors')
                  ->comment('Audit trail: mandor yang menginput absensi ini')
                  ->restrictOnDelete(); // Jangan hapus mandor jika masih ada absensi
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Absen', 'Izin'])
                  ->default('Hadir');
            $table->text('keterangan')->nullable()
                  ->comment('Keterangan tambahan, terutama saat status Izin/Absen');
            $table->timestamps();

            // Satu tukang hanya punya 1 record absensi per proyek per hari
            $table->unique(['tukang_id', 'proyek_id', 'tanggal'], 'unique_absensi_harian');

            // Index untuk query rekap bulanan (dipakai saat hitung gaji)
            $table->index(['tukang_id', 'proyek_id', 'status']);
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
