@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<h4 class="mb-3"><i class="bi bi-clipboard-data"></i> Rekap Absensi</h4>

{{-- Filter --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('admin.absensis.index') }}" class="row g-2">
        <div class="col-12 col-md-4">
            <label class="form-label">Proyek</label>
            <select name="proyek_id" class="form-select">
                <option value="">Semua Proyek</option>
                @foreach($proyeks as $p)
                    <option value="{{ $p->id }}" {{ request('proyek_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_proyek }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Tukang</label>
            <select name="tukang_id" class="form-select">
                <option value="">Semua Tukang</option>
                @foreach($tukangs as $t)
                    <option value="{{ $t->id }}" {{ request('tukang_id') == $t->id ? 'selected' : '' }}>
                        {{ $t->nama_tukang }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="Absen" {{ request('status') == 'Absen' ? 'selected' : '' }}>Absen</option>
                <option value="Izin"  {{ request('status') == 'Izin'  ? 'selected' : '' }}>Izin</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Tanggal Dari</label>
            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Tanggal Sampai</label>
            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
        </div>
        <div class="col-12 col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filter
            </button>
            <a href="{{ route('admin.absensis.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        </div>
    </form>
</div>

{{-- Ringkasan Statistik --}}
<div class="row g-3 mb-3">
    <div class="col-4">
        <div class="card text-center p-3 border-start border-success border-4">
            <div class="fs-3 fw-bold text-success">{{ $ringkasan['hadir'] }}</div>
            <small class="text-muted">Hadir</small>
        </div>
    </div>
    <div class="col-4">
        <div class="card text-center p-3 border-start border-danger border-4">
            <div class="fs-3 fw-bold text-danger">{{ $ringkasan['absen'] }}</div>
            <small class="text-muted">Absen</small>
        </div>
    </div>
    <div class="col-4">
        <div class="card text-center p-3 border-start border-warning border-4">
            <div class="fs-3 fw-bold text-warning">{{ $ringkasan['izin'] }}</div>
            <small class="text-muted">Izin</small>
        </div>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tukang</th>
                    <th>Proyek</th>
                    <th>Status</th>
                    <th>Diinput Oleh</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $absensi)
                <tr>
                    <td data-label="Tanggal">
                        {{ $absensi->tanggal->translatedFormat('d M Y') }}
                    </td>
                    <td data-label="Tukang">{{ $absensi->tukang->nama_tukang ?? '-' }}</td>
                    <td data-label="Proyek">{{ $absensi->proyek->nama_proyek ?? '-' }}</td>
                    <td data-label="Status">
                        <span class="badge bg-{{ $absensi->status_badge }}">{{ $absensi->status }}</span>
                    </td>
                    <td data-label="Diinput Oleh">
                        <small class="text-muted">
                            <i class="bi bi-person"></i> {{ $absensi->mandor->nama_mandor ?? '-' }}
                        </small>
                    </td>
                    <td data-label="Keterangan">{{ $absensi->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Tidak ada data absensi sesuai filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $absensis->links() }}</div>
</div>
@endsection
