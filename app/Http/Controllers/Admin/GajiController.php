<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Tukang;
use App\Models\AuditLog;
use App\Services\GajiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GajiController extends Controller
{
    public function __construct(
        private GajiService $gajiService
    ) {}

    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $gajis = Gaji::with('tukang')
            ->periode($bulan, $tahun)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalTukang = Tukang::count();

        return view('admin.gajis.index', compact('gajis', 'bulan', 'tahun', 'totalTukang'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2100'],
        ]);

        $hasil = $this->gajiService->generateGajiSemuaTukang(
            $validated['bulan'],
            $validated['tahun']
        );

        // Catat ke audit log
        AuditLog::catat(
            userId: Auth::id(),
            aksi: 'generate_gaji',
            model: 'Gaji',
            detail: [
                'bulan'         => $validated['bulan'],
                'tahun'         => $validated['tahun'],
                'jumlah_tukang' => $hasil->count(),
            ],
            ip: $request->ip()
        );

        return redirect()
            ->route('admin.gajis.index', [
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
            ])
            ->with('success', "Berhasil generate gaji untuk {$hasil->count()} tukang.");
    }

    public function show(Gaji $gaji)
    {
        $gaji->load('tukang');

        $breakdown = $this->gajiService->hitungGaji(
            $gaji->tukang,
            $gaji->bulan,
            $gaji->tahun
        );

        return view('admin.gajis.show', compact('gaji', 'breakdown'));
    }

    public function tandaiDibayar(Gaji $gaji, Request $request)
    {
        if ($gaji->status_pembayaran === 'dibayar') {
            return back()->with('error', 'Gaji ini sudah ditandai dibayar sebelumnya.');
        }

        $this->gajiService->tandaiDibayar($gaji, Auth::id());

        AuditLog::catat(
            userId: Auth::id(),
            aksi: 'tandai_dibayar',
            model: 'Gaji',
            modelId: $gaji->id,
            detail: [
                'tukang_id'   => $gaji->tukang_id,
                'nama_tukang' => $gaji->tukang->nama_tukang,
                'periode'     => $gaji->periode_label,
                'total_gaji'  => $gaji->total_gaji,
            ],
            ip: $request->ip()
        );

        return back()->with('success', 'Gaji berhasil ditandai sebagai sudah dibayar.');
    }
}
