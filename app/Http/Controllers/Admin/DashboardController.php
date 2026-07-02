<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Mandor;
use App\Models\Proyek;
use App\Models\Tukang;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mandor'       => Mandor::count(),
            'total_tukang'       => Tukang::count(),
            'total_proyek'       => Proyek::count(),
            'proyek_aktif'       => Proyek::where('status_proyek', 'aktif')->count(),
            'gaji_pending'       => Gaji::where('status_pembayaran', 'pending')->count(),
            'total_gaji_pending' => Gaji::where('status_pembayaran', 'pending')->sum('total_gaji'),
        ];

        $proyekTerbaru = Proyek::latest()->take(5)->get();

        $auditLogs = \App\Models\AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'proyekTerbaru', 'auditLogs'));
    }
}
