@extends('layouts.app')

@section('title', $proyek->nama_proyek)

@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
    <div>
        <h4 class="mb-1">{{ $proyek->nama_proyek }}</h4>
        <p class="text-muted mb-0"><i class="bi bi-geo-alt"></i> {{ $proyek->lokasi ?? '-' }}</p>
    </div>
    <span class="badge bg-{{ $proyek->status_badge }} fs-6">{{ $proyek->status_label }}</span>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center h-100">
            <small class="text-muted">Tanggal Mulai</small>
            <div class="fw-semibold">{{ $proyek->tanggal_mulai?->format('d/m/Y') ?? '-' }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center h-100">
            <small class="text-muted">Tanggal Selesai</small>
            <div class="fw-semibold">{{ $proyek->tanggal_selesai?->format('d/m/Y') ?? '-' }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center h-100">
            <small class="text-muted">Jumlah Tukang</small>
            <div class="fw-semibold">{{ $proyek->plottings->count() }} orang</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.plottings.create') }}" class="card p-3 text-center text-decoration-none h-100 d-flex flex-column justify-content-center">
            <i class="bi bi-plus-circle text-primary fs-4"></i>
            <small>Tambah Tukang</small>
        </a>
    </div>
</div>

<div class="card p-3">
    <h6 class="mb-3"><i class="bi bi-people"></i> Tukang yang Di-plot ke Proyek Ini</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Nama Tukang</th>
                    <th>Skill</th>
                    <th>Tarif Harian</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyek->plottings as $plotting)
                <tr>
                    <td data-label="Nama">{{ $plotting->tukang->nama_tukang ?? '-' }}</td>
                    <td data-label="Skill">{{ $plotting->tukang->skill ?? '-' }}</td>
                    <td data-label="Tarif">{{ $plotting->tarif_format }}</td>
                    <td data-label="Masuk">{{ $plotting->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td>
                    <td data-label="Status">
                        @if($plotting->is_aktif)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Keluar {{ $plotting->tanggal_keluar->format('d/m/Y') }}</span>
                        @endif
                    </td>
                    <td data-label="Aksi" class="text-end">
                        <a href="{{ route('admin.plottings.edit', $plotting) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada tukang yang di-plot ke proyek ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.proyeks.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>
@endsection
