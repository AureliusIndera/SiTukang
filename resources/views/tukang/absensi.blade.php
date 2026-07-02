@extends('layouts.app')

@section('title', 'Absensi Saya')

@section('content')
<h4 class="mb-3"><i class="bi bi-calendar-check"></i> Absensi Saya</h4>

<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('tukang.absensi') }}" class="row g-2">
        <div class="col-6 col-md-4">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select" onchange="this.form.submit()">
                @foreach(range(1, 12) as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($b)->locale('id')->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-4">
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-select" onchange="this.form.submit()">
                @foreach(range(now()->year, now()->year - 3) as $y)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

{{-- Ringkasan Status Bulan Ini --}}
@php
    $totalHadir = $absensis->where('status', 'Hadir')->count();
    $totalAbsen = $absensis->where('status', 'Absen')->count();
    $totalIzin  = $absensis->where('status', 'Izin')->count();
@endphp
<div class="row g-2 mb-3">
    <div class="col-4">
        <div class="card text-center py-2 px-1">
            <div class="fw-bold text-success fs-5">{{ $totalHadir }}</div>
            <small class="text-muted">Hadir</small>
        </div>
    </div>
    <div class="col-4">
        <div class="card text-center py-2 px-1">
            <div class="fw-bold text-danger fs-5">{{ $totalAbsen }}</div>
            <small class="text-muted">Absen</small>
        </div>
    </div>
    <div class="col-4">
        <div class="card text-center py-2 px-1">
            <div class="fw-bold text-warning fs-5">{{ $totalIzin }}</div>
            <small class="text-muted">Izin</small>
        </div>
    </div>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Proyek</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $absensi)
                <tr>
                    <td data-label="Tanggal">
                        {{ $absensi->tanggal->locale('id')->translatedFormat('d M Y') }}
                    </td>
                    <td data-label="Proyek">{{ $absensi->proyek->nama_proyek ?? '-' }}</td>
                    <td data-label="Status">
                        <span class="badge bg-{{ $absensi->status_badge }}">{{ $absensi->status }}</span>
                    </td>
                    <td data-label="Keterangan">{{ $absensi->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Tidak ada data absensi untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $absensis->links() }}</div>
</div>
@endsection
