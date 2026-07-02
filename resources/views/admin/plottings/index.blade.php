@extends('layouts.app')

@section('title', 'Plotting Tukang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0"><i class="bi bi-diagram-3"></i> Plotting Tukang ke Proyek</h4>
    <a href="{{ route('admin.plottings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Plotting
    </a>
</div>

<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('admin.plottings.index') }}" class="row g-2">
        <div class="col-12 col-md-6">
            <select name="proyek_id" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Proyek</option>
                @foreach($proyeks as $p)
                    <option value="{{ $p->id }}" {{ request('proyek_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_proyek }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-card">
            <thead>
                <tr>
                    <th>Tukang</th>
                    <th>Proyek</th>
                    <th>Tarif Harian</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plottings as $plotting)
                <tr>
                    <td data-label="Tukang">{{ $plotting->tukang->nama_tukang ?? '-' }}</td>
                    <td data-label="Proyek">{{ $plotting->proyek->nama_proyek ?? '-' }}</td>
                    <td data-label="Tarif">{{ $plotting->tarif_format }}</td>
                    <td data-label="Masuk">{{ $plotting->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td>
                    <td data-label="Keluar">{{ $plotting->tanggal_keluar?->format('d/m/Y') ?? '-' }}</td>
                    <td data-label="Aksi" class="text-end">
                        <a href="{{ route('admin.plottings.edit', $plotting) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.plottings.destroy', $plotting) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus plotting ini? Tarif untuk tukang ini di proyek ini akan hilang.')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data plotting.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $plottings->links() }}</div>
</div>
@endsection
