@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Absensi Saya</h4>
    <a href="{{ route('mandor.absensi.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Input Absensi
    </a>
</div>

<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('mandor.absensi.index') }}" class="row g-2">
        <div class="col-12 col-md-5">
            <select name="proyek_id" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Proyek</option>
                @foreach($proyeks as $p)
                    <option value="{{ $p->id }}" {{ request('proyek_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_proyek }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" onchange="this.form.submit()">
        </div>
        <div class="col-12 col-md-3">
            <a href="{{ route('mandor.absensi.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-x-circle"></i> Reset Filter
            </a>
        </div>
    </form>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tukang</th>
                    <th>Proyek</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $absensi)
                <tr>
                    <td data-label="Tanggal">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                    <td data-label="Tukang">{{ $absensi->tukang->nama_tukang ?? '-' }}</td>
                    <td data-label="Proyek">{{ $absensi->proyek->nama_proyek ?? '-' }}</td>
                    <td data-label="Status">
                        <span class="badge bg-{{ $absensi->status_badge }}">{{ $absensi->status }}</span>
                    </td>
                    <td data-label="Keterangan">{{ $absensi->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat absensi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $absensis->links() }}</div>
</div>
@endsection
