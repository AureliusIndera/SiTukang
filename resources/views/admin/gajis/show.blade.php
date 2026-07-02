@extends('layouts.app')

@section('title', 'Detail Gaji')

@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
    <div>
        <h4 class="mb-1"><i class="bi bi-receipt"></i> Detail Gaji</h4>
        <p class="text-muted mb-0">{{ $gaji->tukang->nama_tukang }} &mdash; {{ $gaji->periode_label }}</p>
    </div>
    <span class="badge bg-{{ $gaji->status_badge }} fs-6">{{ ucfirst($gaji->status_pembayaran) }}</span>
</div>

<div class="card p-3 mb-3">
    <h6 class="mb-3 text-muted"><i class="bi bi-list-ul"></i> Rincian Perhitungan</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Proyek</th>
                    <th>Jumlah Hadir</th>
                    <th>Tarif Harian</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($breakdown['breakdown'] as $item)
                <tr>
                    <td data-label="Proyek">{{ $item['nama_proyek'] }}</td>
                    <td data-label="Hadir">{{ $item['jumlah_hadir'] }} hari</td>
                    <td data-label="Tarif">Rp {{ number_format($item['tarif_harian'], 0, ',', '.') }}</td>
                    <td data-label="Subtotal" class="fw-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Tidak ada kehadiran pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
            @if(count($breakdown['breakdown']) > 0)
            <tfoot>
                <tr class="table-light">
                    <th colspan="3" class="text-end">Total Gaji</th>
                    <th>{{ $gaji->total_gaji_format }}</th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@if($gaji->status_pembayaran === 'dibayar')
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> Gaji ini sudah ditandai dibayar pada
        <strong>{{ $gaji->dibayar_pada?->format('d/m/Y H:i') }}</strong>
        oleh <strong>{{ $gaji->dibayarOleh->name ?? '-' }}</strong>.
    </div>
@else
    <form action="{{ route('admin.gajis.bayar', $gaji) }}" method="POST"
          onsubmit="return confirm('Tandai gaji ini sebagai sudah dibayar?')">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-lg"></i> Tandai Sudah Dibayar
        </button>
    </form>
@endif

<div class="mt-3">
    <a href="{{ route('admin.gajis.index', ['bulan' => $gaji->bulan, 'tahun' => $gaji->tahun]) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>
@endsection
