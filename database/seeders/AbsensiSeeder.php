<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $tukangIds = DB::table('tukangs')->orderBy('id')->pluck('id');
        $proyekIds = DB::table('proyeks')->orderBy('id')->pluck('id');
        $mandorIds = DB::table('mandors')->orderBy('id')->pluck('id');

        $mandor1 = $mandorIds[0]; // Budi — bertanggung jawab Proyek 1
        $mandor2 = $mandorIds[1]; // Hendra — bertanggung jawab Proyek 2

        $records = [];

        // ----------------------------------------------------------------
        // Proyek 1 (Ruko Solo) — bulan Februari 2024
        // Tukang: Agus[0], Slamet[1], Wahyu[2], Joko[3]
        // Diinput oleh Mandor Budi
        // ----------------------------------------------------------------
        $tanggalP1 = $this->generateTanggalKerja('2024-02-01', '2024-02-29');

        foreach ($tanggalP1 as $idx => $tanggal) {
            // Agus: hadir semua (26 hari)
            $records[] = $this->buat($tukangIds[0], $proyekIds[0], $mandor1, $tanggal, 'Hadir');

            // Slamet: 1x izin di tengah bulan
            $status = ($idx === 9) ? 'Izin' : 'Hadir';
            $records[] = $this->buat($tukangIds[1], $proyekIds[0], $mandor1, $tanggal, $status);

            // Wahyu: 2x absen
            $status = in_array($idx, [4, 17]) ? 'Absen' : 'Hadir';
            $records[] = $this->buat($tukangIds[2], $proyekIds[0], $mandor1, $tanggal, $status);

            // Joko: 3x izin
            $status = in_array($idx, [2, 13, 20]) ? 'Izin' : 'Hadir';
            $records[] = $this->buat($tukangIds[3], $proyekIds[0], $mandor1, $tanggal, $status);
        }

        // ----------------------------------------------------------------
        // Proyek 2 (Renovasi Godean) — bulan Februari 2024
        // Tukang: Agus[0], Eko[4], Slamet[1]
        // Diinput oleh Mandor Hendra
        // CATATAN: Agus bekerja di DUA proyek bulan yang sama
        // ----------------------------------------------------------------
        $tanggalP2 = $this->generateTanggalKerja('2024-02-05', '2024-02-29');

        foreach ($tanggalP2 as $idx => $tanggal) {
            // Agus: 2x absen di proyek 2
            $status = in_array($idx, [3, 12]) ? 'Absen' : 'Hadir';
            $records[] = $this->buat($tukangIds[0], $proyekIds[1], $mandor2, $tanggal, $status);

            // Eko: hadir semua
            $records[] = $this->buat($tukangIds[4], $proyekIds[1], $mandor2, $tanggal, 'Hadir');

            // Slamet: 1x izin
            $status = ($idx === 7) ? 'Izin' : 'Hadir';
            $records[] = $this->buat($tukangIds[1], $proyekIds[1], $mandor2, $tanggal, $status);
        }

        // Insert semua sekaligus
        foreach (array_chunk($records, 100) as $chunk) {
            DB::table('absensis')->insert($chunk);
        }
    }

    /**
     * Generate tanggal hari kerja (Senin-Sabtu, skip Minggu)
     * antara dua tanggal.
     */
    private function generateTanggalKerja(string $mulai, string $selesai): array
    {
        $tanggals = [];
        $current  = Carbon::parse($mulai);
        $end      = Carbon::parse($selesai);

        while ($current->lte($end)) {
            // Skip hari Minggu (0 = Sunday)
            if ($current->dayOfWeek !== Carbon::SUNDAY) {
                $tanggals[] = $current->toDateString();
            }
            $current->addDay();
        }

        return $tanggals;
    }

    /**
     * Helper buat satu record absensi.
     */
    private function buat(int $tukangId, int $proyekId, int $mandorId, string $tanggal, string $status): array
    {
        return [
            'tukang_id'  => $tukangId,
            'proyek_id'  => $proyekId,
            'mandor_id'  => $mandorId,
            'tanggal'    => $tanggal,
            'status'     => $status,
            'keterangan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
