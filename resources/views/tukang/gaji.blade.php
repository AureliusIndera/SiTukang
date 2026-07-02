@extends('layouts.app')

@section('title', 'Gaji Saya')

@section('content')
<h4 class="mb-3"><i class="bi bi-cash-coin"></i> Riwayat Gaji Saya</h4>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Hari Kerja</th>
                    <th>Total Gaji</th>
                    <th>Status</th>
                    <th class="text-end">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gajis as $gaji)
                <tr>
                    <td data-label="Periode">{{ $gaji->periode_label }}</td>
                    <td data-label="Hari Kerja">{{ $gaji->total_hari_kerja }} hari</td>
                    <td data-label="Total Gaji" class="fw-semibold text-success">
                        {{ $gaji->total_gaji_format }}
                    </td>
                    <td data-label="Status">
                        <span class="badge bg-{{ $gaji->status_badge }}">
                            {{ ucfirst($gaji->status_pembayaran) }}
                        </span>
                        @if($gaji->dibayar_pada)
                            <div class="small text-muted">{{ $gaji->dibayar_pada->format('d/m/Y') }}</div>
                        @endif
                    </td>
                    <td data-label="Detail" class="text-end">
                        <a href="{{ route('tukang.gaji.detail', $gaji) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada data gaji. Hubungi admin jika bulan ini sudah lewat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $gajis->links() }}</div>
</div>
@endsection
