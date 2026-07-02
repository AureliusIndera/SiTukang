@extends('layouts.app')

@section('title', 'Kelola Proyek')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0"><i class="bi bi-building"></i> Kelola Proyek</h4>
    <a href="{{ route('admin.proyeks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Proyek
    </a>
</div>

<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('admin.proyeks.index') }}" class="row g-2">
        <div class="col-12 col-md-4">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Cari nama proyek..." value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-2">
            <button class="btn btn-outline-secondary w-100" type="submit"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Jumlah Tukang</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyeks as $proyek)
                <tr>
                    <td data-label="Nama Proyek">
                        <a href="{{ route('admin.proyeks.show', $proyek) }}" class="text-decoration-none fw-semibold">
                            {{ $proyek->nama_proyek }}
                        </a>
                    </td>
                    <td data-label="Lokasi">{{ $proyek->lokasi ?? '-' }}</td>
                    <td data-label="Status">
                        <span class="badge bg-{{ $proyek->status_badge }}">{{ $proyek->status_label }}</span>
                    </td>
                    <td data-label="Jumlah Tukang">{{ $proyek->tukangs_count }} orang</td>
                    <td data-label="Aksi" class="text-end">
                        <a href="{{ route('admin.proyeks.show', $proyek) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.proyeks.edit', $proyek) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.proyeks.destroy', $proyek) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus proyek ini? Semua data plotting & absensi terkait akan ikut terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada proyek.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $proyeks->links() }}</div>
</div>
@endsection
