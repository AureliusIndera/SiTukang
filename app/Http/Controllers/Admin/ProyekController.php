<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProyekRequest;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index(Request $request)
    {
        $query = Proyek::query();

        if ($request->filled('status')) {
            $query->where('status_proyek', $request->input('status'));
        }

        if ($request->filled('search')) {
            $query->where('nama_proyek', 'like', '%' . $request->input('search') . '%');
        }

        $proyeks = $query->withCount('tukangs')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.proyeks.index', compact('proyeks'));
    }

    public function create()
    {
        return view('admin.proyeks.create');
    }

    public function store(StoreProyekRequest $request)
    {
        Proyek::create($request->validated());

        return redirect()
            ->route('admin.proyeks.index')
            ->with('success', 'Proyek baru berhasil ditambahkan.');
    }

    public function show(Proyek $proyek)
    {
        $proyek->load(['tukangs', 'plottings.tukang']);

        return view('admin.proyeks.show', compact('proyek'));
    }

    public function edit(Proyek $proyek)
    {
        return view('admin.proyeks.edit', compact('proyek'));
    }

    public function update(StoreProyekRequest $request, Proyek $proyek)
    {
        $proyek->update($request->validated());

        return redirect()
            ->route('admin.proyeks.index')
            ->with('success', 'Data proyek berhasil diperbarui.');
    }

    public function destroy(Proyek $proyek)
    {
        $proyek->delete();

        return redirect()
            ->route('admin.proyeks.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }
}
