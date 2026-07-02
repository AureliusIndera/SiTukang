@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h4 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard Admin</h4>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center p-3 h-100">
            <i class="bi bi-person-badge fs-2 text-primary"></i>
            <h3 class="mt-2 mb-0">{{ $stats['total_mandor'] }}</h3>
            <small class="text-muted">Mandor</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3 h-100">
            <i class="bi bi-people fs-2 text-success"></i>
            <h3 class="mt-2 mb-0">{{ $stats['total_tukang'] }}</h3>
            <small class="text-muted">Tukang</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3 h-100">
            <i class="bi bi-building fs-2 text-warning"></i>
            <h3 class="mt-2 mb-0">{{ $stats['proyek_aktif'] }} / {{ $stats['total_proyek'] }}</h3>
            <small class="text-muted">Proyek Aktif</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3 h-100">
            <i class="bi bi-cash-stack fs-2 text-danger"></i>
            <h3 class="mt-2 mb-0">{{ $stats['gaji_pending'] }}</h3>
            <small class="text-muted">Gaji Pending</small>
        </div>
    </div>
</div>

<div class="card p-3 mb-4">
    <h6 class="text-muted mb-1">Total Gaji Belum Dibayar</h6>
    <h3 class="text-danger mb-0">Rp {{ number_format($stats['total_gaji_pending'], 0, ',', '.') }}</h3>
</div>

<div class="card p-3">
    <h6 class="mb-3"><i class="bi bi-building"></i> Proyek Terbaru</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyekTerbaru as $proyek)
                <tr>
                    <td data-label="Nama Proyek">{{ $proyek->nama_proyek }}</td>
                    <td data-label="Lokasi">{{ $proyek->lokasi ?? '-' }}</td>
                    <td data-label="Status">
                        <span class="badge bg-{{ $proyek->status_badge }}">{{ $proyek->status_label }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">Belum ada proyek.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card p-3 mt-3">
    <h6 class="mb-3"><i class="bi bi-journal-text"></i> Aktivitas Terakhir</h6>
    @forelse($auditLogs as $log)
        <div class="d-flex justify-content-between align-items-start border-bottom py-2">
            <div>
                <span class="badge bg-secondary me-1">{{ $log->aksi }}</span>
                <small>
                    oleh <strong>{{ $log->user->name ?? '-' }}</strong>
                    @if($log->detail)
                        @if($log->aksi === 'generate_gaji')
                            — Generate gaji
                            {{ \Carbon\Carbon::create()->month($log->detail['bulan'])->locale('id')->translatedFormat('F') }}
                            {{ $log->detail['tahun'] }}
                            ({{ $log->detail['jumlah_tukang'] }} tukang)
                        @elseif($log->aksi === 'tandai_dibayar')
                            — Bayar gaji {{ $log->detail['nama_tukang'] ?? '-' }}
                            periode {{ $log->detail['periode'] ?? '-' }}
                        @endif
                    @endif
                </small>
            </div>
            <small class="text-muted text-nowrap ms-2">
                {{ $log->created_at->diffForHumans() }}
            </small>
        </div>
    @empty
        <p class="text-muted mb-0">Belum ada aktivitas tercatat.</p>
    @endforelse
</div>

@endsection
