<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mandor\StoreAbsensiRequest;
use App\Models\Absensi;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $mandor = Auth::user()->mandor;

        $query = Absensi::with(['tukang', 'proyek'])
            ->where('mandor_id', $mandor->id);

        if ($request->filled('proyek_id')) {
            $query->where('proyek_id', $request->input('proyek_id'));
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->input('tanggal'));
        }

        $absensis = $query->latest('tanggal')->paginate(20)->withQueryString();
        $proyeks  = Proyek::orderBy('nama_proyek')->get();

        return view('mandor.absensi.index', compact('absensis', 'proyeks'));
    }

    public function create(Request $request)
    {
        $proyeks = Proyek::where('status_proyek', 'aktif')
            ->orderBy('nama_proyek')
            ->get();

        $proyek          = null;
        $tukangs         = collect();
        $tanggal         = $request->input('tanggal', now()->toDateString());
        $absensiExisting = collect();

        if ($request->filled('proyek_id')) {
            $proyek = Proyek::with('plottings.tukang')->findOrFail($request->input('proyek_id'));

            $tukangs = $proyek->plottings
                ->filter(fn($p) => is_null($p->tanggal_keluar) || $p->tanggal_keluar->gte($tanggal))
                ->map(fn($p) => $p->tukang)
                ->filter();

            $absensiExisting = Absensi::where('proyek_id', $proyek->id)
                ->whereDate('tanggal', $tanggal)
                ->get()
                ->keyBy('tukang_id');
        }

        return view('mandor.absensi.create', compact(
            'proyeks',
            'proyek',
            'tukangs',
            'tanggal',
            'absensiExisting'
        ));
    }

    public function store(StoreAbsensiRequest $request)
    {
        $validated = $request->validated();
        $mandor    = Auth::user()->mandor;

        $sudahAda = Absensi::where('proyek_id', $validated['proyek_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->exists();

        DB::transaction(function () use ($validated, $mandor) {
            foreach ($validated['absensi'] as $item) {
                Absensi::updateOrCreate(
                    [
                        'tukang_id' => $item['tukang_id'],
                        'proyek_id' => $validated['proyek_id'],
                        'tanggal'   => $validated['tanggal'],
                    ],
                    [
                        'mandor_id'  => $mandor->id,
                        'status'     => $item['status'],
                        'keterangan' => $item['keterangan'] ?? null,
                    ]
                );
            }
        });

        $pesan = $sudahAda
            ? 'Absensi berhasil diperbarui untuk ' . count($validated['absensi']) . ' tukang. (Data lama ditimpa)'
            : 'Absensi berhasil disimpan untuk ' . count($validated['absensi']) . ' tukang.';

        return redirect()
            ->route('mandor.absensi.index')
            ->with($sudahAda ? 'warning' : 'success', $pesan);
    }
}
