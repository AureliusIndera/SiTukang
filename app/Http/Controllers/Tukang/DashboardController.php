<?php

namespace App\Http\Controllers\Tukang;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard tukang: ringkasan proyek yang sedang diikuti
     * dan rekap kehadiran bulan ini.
     */
    public function index()
    {
        $tukang = Auth::user()->tukang;

        $proyekAktif = $tukang->plottings()
            ->with('proyek')
            ->whereNull('tanggal_keluar')
            ->get();

        $bulan = now()->month;
        $tahun = now()->year;

        $rekapBulanIni = Absensi::where('tukang_id', $tukang->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $gajiBulanLalu = Gaji::where('tukang_id', $tukang->id)
            ->periode(now()->subMonth()->month, now()->subMonth()->year)
            ->first();

        return view('tukang.dashboard', compact(
            'tukang',
            'proyekAktif',
            'rekapBulanIni',
            'gajiBulanLalu'
        ));
    }

    public function absensi(Request $request)
    {
        $tukang = Auth::user()->tukang;

        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $absensis = Absensi::with('proyek')
            ->where('tukang_id', $tukang->id)
            ->bulanIni($bulan, $tahun)
            ->latest('tanggal')
            ->paginate(20)
            ->withQueryString();

        return view('tukang.absensi', compact('absensis', 'bulan', 'tahun'));
    }

    public function gaji()
    {
        $tukang = Auth::user()->tukang;

        $gajis = Gaji::where('tukang_id', $tukang->id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->paginate(12);

        return view('tukang.gaji', compact('gajis'));
    }

    public function gajiDetail(Gaji $gaji, \App\Services\GajiService $gajiService)
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $gaji);

        $breakdown = $gajiService->hitungGaji($gaji->tukang, $gaji->bulan, $gaji->tahun);

        return view('tukang.gaji-detail', compact('gaji', 'breakdown'));
    }
}
