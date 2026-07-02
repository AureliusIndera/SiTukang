<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePlottingRequest;
use App\Models\PlottingTukang;
use App\Models\Proyek;
use App\Models\Tukang;
use Illuminate\Http\Request;

class PlottingController extends Controller
{

    public function index(Request $request)
    {
        $query = PlottingTukang::with(['tukang', 'proyek']);

        if ($request->filled('proyek_id')) {
            $query->where('proyek_id', $request->input('proyek_id'));
        }

        $plottings = $query->latest()->paginate(10)->withQueryString();
        $proyeks   = Proyek::orderBy('nama_proyek')->get();

        return view('admin.plottings.index', compact('plottings', 'proyeks'));
    }

    public function create()
    {
        $tukangs = Tukang::orderBy('nama_tukang')->get();
        $proyeks = Proyek::where('status_proyek', '!=', 'selesai')
            ->orderBy('nama_proyek')
            ->get();

        return view('admin.plottings.create', compact('tukangs', 'proyeks'));
    }

    public function store(StorePlottingRequest $request)
    {
        $validated = $request->validated();

        $sudahAda = PlottingTukang::where('tukang_id', $validated['tukang_id'])
            ->where('proyek_id', $validated['proyek_id'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Tukang ini sudah pernah di-plot ke proyek tersebut. Silakan edit data yang sudah ada.');
        }

        PlottingTukang::create($validated);

        return redirect()
            ->route('admin.plottings.index')
            ->with('success', 'Tukang berhasil di-plot ke proyek dengan tarif harian yang ditentukan.');
    }

    public function edit(PlottingTukang $plotting)
    {
        $plotting->load(['tukang', 'proyek']);

        return view('admin.plottings.edit', compact('plotting'));
    }

    public function update(Request $request, PlottingTukang $plotting)
    {
        $validated = $request->validate([
            'tarif_harian'   => ['required', 'numeric', 'min:0'],
            'tanggal_masuk'  => ['nullable', 'date'],
            'tanggal_keluar' => ['nullable', 'date', 'after_or_equal:tanggal_masuk'],
        ]);

        $plotting->update($validated);

        return redirect()
            ->route('admin.plottings.index')
            ->with('success', 'Data plotting berhasil diperbarui.');
    }

    public function destroy(PlottingTukang $plotting)
    {
        $plotting->delete();

        return redirect()
            ->route('admin.plottings.index')
            ->with('success', 'Plotting tukang berhasil dihapus dari proyek.');
    }
}
