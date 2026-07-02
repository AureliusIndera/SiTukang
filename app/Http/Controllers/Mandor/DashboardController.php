<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mandor = Auth::user()->mandor;

        $proyekAktif = Proyek::where('status_proyek', 'aktif')
            ->orderBy('nama_proyek')
            ->get();

        $absensiTerbaru = Absensi::with(['tukang', 'proyek'])
            ->where('mandor_id', $mandor->id)
            ->latest('tanggal')
            ->take(10)
            ->get();

        return view('mandor.dashboard', compact('mandor', 'proyekAktif', 'absensiTerbaru'));
    }
}
