<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyekSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proyeks')->insert([
            [
                'nama_proyek'     => 'Pembangunan Ruko Jl. Solo KM 8',
                'lokasi'          => 'Jl. Solo KM 8, Maguwoharjo, Depok, Sleman',
                'status_proyek'   => 'aktif',
                'tanggal_mulai'   => '2024-01-15',
                'tanggal_selesai' => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nama_proyek'     => 'Renovasi Gedung Kantor Godean',
                'lokasi'          => 'Jl. Godean KM 4, Sidoagung, Godean, Sleman',
                'status_proyek'   => 'aktif',
                'tanggal_mulai'   => '2024-02-01',
                'tanggal_selesai' => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
