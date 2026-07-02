<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\Gaji;
use App\Models\Tukang;
use Illuminate\Support\Collection;

class GajiService
{
    /**
     * Hitung gaji satu tukang untuk periode tertentu.
     *
     * Rumus:
     * total_gaji = Σ (jumlah_hadir_di_proyek_X * tarif_harian_di_proyek_X)
     * untuk semua proyek yang pernah/sedang di-plot ke tukang ini.
     *
     * @return array{
     *     breakdown: array<int, array{
     *         proyek_id: int,
     *         nama_proyek: string,
     *         jumlah_hadir: int,
     *         tarif_harian: float,
     *         subtotal: float
     *     }>,
     *     total_hari_kerja: int,
     *     total_gaji: float
     * }
     */
    public function hitungGaji(Tukang $tukang, int $bulan, int $tahun): array
    {
        // Ambil semua proyek yang pernah di-plot ke tukang ini,
        // beserta tarif_harian dari pivot table plotting_tukangs.
        $plottings = $tukang->plottings()->with('proyek')->get();

        $breakdown       = [];
        $totalGaji       = 0;
        $totalHariKerja  = 0;

        foreach ($plottings as $plotting) {
            // Hitung jumlah hari "Hadir" tukang ini DI PROYEK INI,
            // pada bulan & tahun yang dipilih.
            $jumlahHadir = Absensi::where('tukang_id', $tukang->id)
                ->where('proyek_id', $plotting->proyek_id)
                ->where('status', 'Hadir')
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->count();

            // Tarif harian khusus untuk proyek ini (dari pivot)
            $tarifHarian = (float) $plotting->tarif_harian;
            $subtotal    = $jumlahHadir * $tarifHarian;

            // Hanya masukkan ke breakdown jika ada aktivitas
            // (jumlah hadir > 0) agar laporan tidak penuh proyek kosong.
            if ($jumlahHadir > 0) {
                $breakdown[] = [
                    'proyek_id'    => $plotting->proyek_id,
                    'nama_proyek'  => $plotting->proyek->nama_proyek ?? '-',
                    'jumlah_hadir' => $jumlahHadir,
                    'tarif_harian' => $tarifHarian,
                    'subtotal'     => $subtotal,
                ];
            }

            $totalGaji      += $subtotal;
            $totalHariKerja += $jumlahHadir;
        }

        return [
            'breakdown'        => $breakdown,
            'total_hari_kerja' => $totalHariKerja,
            'total_gaji'       => $totalGaji,
        ];
    }

    /**
     * Generate atau update record Gaji (rekap bulanan) untuk satu tukang.
     *
     * Jika gaji untuk periode ini sudah berstatus 'dibayar',
     * maka TIDAK akan dihitung ulang (untuk menjaga histori pembayaran).
     */
    public function generateOrUpdateGaji(Tukang $tukang, int $bulan, int $tahun): Gaji
    {
        $existing = Gaji::where('tukang_id', $tukang->id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        // Jangan timpa gaji yang sudah dibayar
        if ($existing && $existing->status_pembayaran === 'dibayar') {
            return $existing;
        }

        $hasil = $this->hitungGaji($tukang, $bulan, $tahun);

        return Gaji::updateOrCreate(
            [
                'tukang_id' => $tukang->id,
                'bulan'     => $bulan,
                'tahun'     => $tahun,
            ],
            [
                'total_hari_kerja' => $hasil['total_hari_kerja'],
                'total_gaji'       => $hasil['total_gaji'],
            ]
        );
    }

    /**
     * Generate/update rekap gaji untuk SEMUA tukang pada periode tertentu.
     * Dipakai oleh Admin saat menekan tombol "Generate Gaji Bulan Ini".
     *
     * @return Collection<int, Gaji>
     */
    public function generateGajiSemuaTukang(int $bulan, int $tahun): Collection
    {
        return Tukang::all()->map(
            fn (Tukang $tukang) => $this->generateOrUpdateGaji($tukang, $bulan, $tahun)
        );
    }

    public function tandaiDibayar(Gaji $gaji, int $adminUserId): Gaji
    {
        $gaji->update([
            'status_pembayaran' => 'dibayar',
            'dibayar_pada'      => now(),
            'dibayar_oleh'      => $adminUserId,
        ]);

        return $gaji;
    }
}
