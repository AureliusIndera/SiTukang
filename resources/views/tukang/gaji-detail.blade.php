@extends('layouts.app')

@section('title', 'Detail Gaji')

@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
    <div>
        <h4 class="mb-1"><i class="bi bi-receipt"></i> Detail Gaji</h4>
        <p class="text-muted mb-0">{{ $gaji->periode_label }}</p>
    </div>
    <span class="badge bg-{{ $gaji->status_badge }} fs-6">{{ ucfirst($gaji->status_pembayaran) }}</span>
</div>

{{-- Ringkasan --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-md-4">
        <div class="card p-3 text-center h-100">
            <small class="text-muted">Total Hari Kerja</small>
            <div class="fs-3 fw-bold">{{ $gaji->total_hari_kerja }}</div>
            <small class="text-muted">hari</small>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card p-3 text-center h-100">
            <small class="text-muted">Total Gaji</small>
            <div class="fs-4 fw-bold text-success">{{ $gaji->total_gaji_format }}</div>
        </div>
    </div>
    @if($gaji->dibayar_pada)
    <div class="col-12 col-md-4">
        <div class="card p-3 text-center h-100">
            <small class="text-muted">Dibayar Pada</small>
            <div class="fw-semibold">{{ $gaji->dibayar_pada->format('d/m/Y') }}</div>
        </div>
    </div>
    @endif
</div>

{{-- Breakdown per Proyek --}}
<div class="card p-3 mb-3">
    <h6 class="mb-3 text-muted"><i class="bi bi-list-ul"></i> Rincian Per Proyek</h6>

    @forelse($breakdown['breakdown'] as $item)
        <div class="border rounded p-3 mb-2">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                <div>
                    <div class="fw-semibold">{{ $item['nama_proyek'] }}</div>
                    <small class="text-muted">
                        {{ $item['jumlah_hadir'] }} hari &times;
                        Rp {{ number_format($item['tarif_harian'], 0, ',', '.') }}/hari
                    </small>
                </div>
                <div class="fw-bold text-success">
                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted mb-0">Tidak ada kehadiran pada periode ini.</p>
    @endforelse

    @if(count($breakdown['breakdown']) > 1)
        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
            <span class="fw-semibold">Total</span>
            <span class="fw-bold fs-5 text-success">{{ $gaji->total_gaji_format }}</span>
        </div>
    @endif
</div>

@if($gaji->catatan)
    <div class="alert alert-secondary">
        <i class="bi bi-sticky"></i> <strong>Catatan:</strong> {{ $gaji->catatan }}
    </div>
@endif

<a href="{{ route('tukang.gaji') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Kembali
</a>
@endsection
