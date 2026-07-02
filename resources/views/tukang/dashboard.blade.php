@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
<h4 class="mb-1"><i class="bi bi-speedometer2"></i> Dashboard</h4>
<p class="text-muted mb-4">Selamat datang, <strong>{{ $tukang->nama_tukang }}</strong></p>

{{-- Rekap Kehadiran Bulan Ini --}}
<div class="row g-3 mb-4">
    <div class="col-4">
        <div class="card text-center p-3 h-100 border-start border-success border-4">
            <div class="fs-2 fw-bold text-success">{{ $rekapBulanIni->get('Hadir', 0) }}</div>
            <small class="text-muted">Hadir</small>
        </div>
    </div>
    <div class="col-4">
        <div class="card text-center p-3 h-100 border-start border-danger border-4">
            <div class="fs-2 fw-bold text-danger">{{ $rekapBulanIni->get('Absen', 0) }}</div>
            <small class="text-muted">Absen</small>
        </div>
    </div>
    <div class="col-4">
        <div class="card text-center p-3 h-100 border-start border-warning border-4">
            <div class="fs-2 fw-bold text-warning">{{ $rekapBulanIni->get('Izin', 0) }}</div>
            <small class="text-muted">Izin</small>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Proyek Aktif --}}
    <div class="col-12 col-md-6">
        <div class="card p-3 h-100">
            <h6 class="mb-3"><i class="bi bi-building"></i> Proyek Saya Saat Ini</h6>
            @forelse($proyekAktif as $plotting)
                <div class="d-flex justify-content-between align-items-start border-bottom py-2">
                    <div>
                        <div class="fw-semibold">{{ $plotting->proyek->nama_proyek ?? '-' }}</div>
                        <small class="text-muted">
                            <i class="bi bi-geo-alt"></i> {{ $plotting->proyek->lokasi ?? '-' }}
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">Aktif</span>
                        <div class="small text-muted mt-1">
                            Rp {{ number_format($plotting->tarif_harian, 0, ',', '.') }}/hari
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">Belum di-plot ke proyek manapun.</p>
            @endforelse
        </div>
    </div>

    {{-- Gaji Bulan Lalu --}}
    <div class="col-12 col-md-6">
        <div class="card p-3 h-100">
            <h6 class="mb-3">
                <i class="bi bi-cash-coin"></i> Gaji Bulan Lalu
                <small class="text-muted">({{ \Carbon\Carbon::now()->subMonth()->locale('id')->translatedFormat('F Y') }})</small>
            </h6>
            @if($gajiBulanLalu)
                <div class="mb-2">
                    <small class="text-muted">Total Hari Kerja</small>
                    <div class="fw-semibold">{{ $gajiBulanLalu->total_hari_kerja }} hari</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Total Gaji</small>
                    <div class="fs-4 fw-bold text-success">{{ $gajiBulanLalu->total_gaji_format }}</div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-{{ $gajiBulanLalu->status_badge }} fs-6">
                        {{ ucfirst($gajiBulanLalu->status_pembayaran) }}
                    </span>
                    <a href="{{ route('tukang.gaji.detail', $gajiBulanLalu) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                </div>
            @else
                <p class="text-muted mb-0">Data gaji bulan lalu belum tersedia.</p>
            @endif
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-6">
        <a href="{{ route('tukang.absensi') }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-calendar-check"></i> Lihat Absensi Saya
        </a>
    </div>
    <div class="col-6">
        <a href="{{ route('tukang.gaji') }}" class="btn btn-outline-success w-100">
            <i class="bi bi-cash-coin"></i> Lihat Gaji Saya
        </a>
    </div>
</div>
@endsection
