<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Proyek;
use App\Models\Tukang;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['tukang', 'proyek', 'mandor']);

        if ($request->filled('proyek_id')) {
            $query->where('proyek_id', $request->input('proyek_id'));
        }

        if ($request->filled('tukang_id')) {
            $query->where('tukang_id', $request->input('tukang_id'));
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->input('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->input('tanggal_sampai'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $absensis = $query->latest('tanggal')->paginate(20)->withQueryString();

        $ringkasan = [
            'hadir' => (clone $query)->where('status', 'Hadir')->count(),
            'absen' => (clone $query)->where('status', 'Absen')->count(),
            'izin'  => (clone $query)->where('status', 'Izin')->count(),
        ];

        $proyeks = Proyek::orderBy('nama_proyek')->get();
        $tukangs = Tukang::orderBy('nama_tukang')->get();

        return view('admin.absensis.index', compact(
            'absensis', 'ringkasan', 'proyeks', 'tukangs'
        ));
    }
}