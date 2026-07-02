<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlottingTukangSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID dinamis agar tidak hardcode
        $tukangIds  = DB::table('tukangs')->orderBy('id')->pluck('id');
        $proyekIds  = DB::table('proyeks')->orderBy('id')->pluck('id');

        // $tukangIds[0] = Agus   (Tukang Batu)
        // $tukangIds[1] = Slamet (Tukang Kayu)
        // $tukangIds[2] = Wahyu  (Tukang Las)
        // $tukangIds[3] = Joko   (Tukang Cat)
        // $tukangIds[4] = Eko    (Tukang Batu)

        // $proyekIds[0] = Proyek Ruko Solo
        // $proyekIds[1] = Proyek Renovasi Godean

        $plottings = [
            // Proyek 1: Ruko Solo — 4 tukang
            [
                'tukang_id'     => $tukangIds[0], // Agus
                'proyek_id'     => $proyekIds[0],
                'tarif_harian'  => 150000.00,
                'tanggal_masuk' => '2024-01-15',
            ],
            [
                'tukang_id'     => $tukangIds[1], // Slamet
                'proyek_id'     => $proyekIds[0],
                'tarif_harian'  => 175000.00,
                'tanggal_masuk' => '2024-01-15',
            ],
            [
                'tukang_id'     => $tukangIds[2], // Wahyu
                'proyek_id'     => $proyekIds[0],
                'tarif_harian'  => 200000.00,
                'tanggal_masuk' => '2024-01-20',
            ],
            [
                'tukang_id'     => $tukangIds[3], // Joko
                'proyek_id'     => $proyekIds[0],
                'tarif_harian'  => 140000.00,
                'tanggal_masuk' => '2024-01-20',
            ],

            // Proyek 2: Renovasi Godean — 3 tukang (Agus & Eko masuk keduanya)
            [
                'tukang_id'     => $tukangIds[0], // Agus — tarifnya BERBEDA di proyek ini
                'proyek_id'     => $proyekIds[1],
                'tarif_harian'  => 160000.00,
                'tanggal_masuk' => '2024-02-01',
            ],
            [
                'tukang_id'     => $tukangIds[4], // Eko
                'proyek_id'     => $proyekIds[1],
                'tarif_harian'  => 150000.00,
                'tanggal_masuk' => '2024-02-01',
            ],
            [
                'tukang_id'     => $tukangIds[1], // Slamet — juga di proyek 2
                'proyek_id'     => $proyekIds[1],
                'tarif_harian'  => 180000.00,
                'tanggal_masuk' => '2024-02-05',
            ],
        ];

        foreach ($plottings as $plotting) {
            DB::table('plotting_tukangs')->insert(array_merge($plotting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
