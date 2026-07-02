@extends('layouts.app')

@section('title', 'Dashboard Mandor')

@section('content')
<h4 class="mb-1"><i class="bi bi-speedometer2"></i> Dashboard Mandor</h4>
<p class="text-muted mb-4">Selamat datang, <strong>{{ $mandor->nama_mandor }}</strong></p>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card p-3 h-100">
            <h6 class="mb-3"><i class="bi bi-building"></i> Proyek Aktif</h6>
            @forelse($proyekAktif as $proyek)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <div class="fw-semibold">{{ $proyek->nama_proyek }}</div>
                        <small class="text-muted">{{ $proyek->lokasi ?? '-' }}</small>
                    </div>
                    <a href="{{ route('mandor.absensi.create', ['proyek_id' => $proyek->id, 'tanggal' => now()->toDateString()]) }}"
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-clipboard-check"></i> Absensi
                    </a>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada proyek aktif.</p>
            @endforelse
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card p-3 h-100">
            <h6 class="mb-3"><i class="bi bi-clock-history"></i> Absensi Terbaru Diinput</h6>
            @forelse($absensiTerbaru as $absensi)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <div class="fw-semibold">{{ $absensi->tukang->nama_tukang ?? '-' }}</div>
                        <small class="text-muted">
                            {{ $absensi->proyek->nama_proyek ?? '-' }} &middot; {{ $absensi->tanggal->format('d/m/Y') }}
                        </small>
                    </div>
                    <span class="badge bg-{{ $absensi->status_badge }}">{{ $absensi->status }}</span>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada absensi yang diinput.</p>
            @endforelse
        </div>
    </div>
</div>

<a href="{{ route('mandor.absensi.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Input Absensi Baru
</a>
@endsection
