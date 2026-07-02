@extends('layouts.app')

@section('title', 'Rekap Gaji')

@section('content')
<h4 class="mb-3"><i class="bi bi-cash-stack"></i> Rekap Gaji Bulanan</h4>

<div class="card p-3 mb-3">
    <div class="row g-2 align-items-end">
        <form method="GET" action="{{ route('admin.gajis.index') }}" class="col-12 col-md-8 row g-2">
            <div class="col-6 col-md-4">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach(range(1, 12) as $b)
                        <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->locale('id')->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-4">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach(range(now()->year, now()->year - 3) as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-funnel"></i> Tampilkan
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.gajis.generate') }}" class="col-12 col-md-4">
            @csrf
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit" class="btn btn-primary w-100"
                    onclick="return confirm('Generate / hitung ulang gaji untuk semua tukang periode ini?')">
                <i class="bi bi-calculator"></i> Generate Gaji
            </button>
        </form>
    </div>
    <small class="text-muted d-block mt-2">
        Total tukang terdaftar: <strong>{{ $totalTukang }}</strong> orang.
        Gaji yang sudah <span class="badge bg-success">Dibayar</span> tidak akan dihitung ulang.
    </small>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Nama Tukang</th>
                    <th>Periode</th>
                    <th>Total Hari Kerja</th>
                    <th>Total Gaji</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gajis as $gaji)
                <tr>
                    <td data-label="Nama">{{ $gaji->tukang->nama_tukang ?? '-' }}</td>
                    <td data-label="Periode">{{ $gaji->periode_label }}</td>
                    <td data-label="Hari Kerja">{{ $gaji->total_hari_kerja }} hari</td>
                    <td data-label="Total Gaji" class="fw-semibold">{{ $gaji->total_gaji_format }}</td>
                    <td data-label="Status">
                        <span class="badge bg-{{ $gaji->status_badge }}">{{ ucfirst($gaji->status_pembayaran) }}</span>
                    </td>
                    <td data-label="Aksi" class="text-end">
                        <a href="{{ route('admin.gajis.show', $gaji) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        @if($gaji->status_pembayaran === 'pending')
                            <form action="{{ route('admin.gajis.bayar', $gaji) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Tandai gaji ini sebagai sudah dibayar?')">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-check-lg"></i> Bayar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada data gaji untuk periode ini. Klik <strong>Generate Gaji</strong> untuk membuatnya.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $gajis->links() }}</div>
</div>
@endsection
