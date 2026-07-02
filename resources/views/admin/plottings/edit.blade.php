@extends('layouts.app')

@section('title', 'Edit Plotting')

@section('content')
<h4 class="mb-3"><i class="bi bi-pencil-square"></i> Edit Plotting</h4>

<div class="card p-3 p-md-4">
    <div class="mb-4 p-3 bg-light rounded">
        <div class="row">
            <div class="col-6">
                <small class="text-muted">Tukang</small>
                <div class="fw-semibold">{{ $plotting->tukang->nama_tukang }}</div>
            </div>
            <div class="col-6">
                <small class="text-muted">Proyek</small>
                <div class="fw-semibold">{{ $plotting->proyek->nama_proyek }}</div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.plottings.update', $plotting) }}">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <label class="form-label">Tarif Harian (Rp)</label>
                <input type="number" name="tarif_harian" class="form-control @error('tarif_harian') is-invalid @enderror"
                       value="{{ old('tarif_harian', $plotting->tarif_harian) }}" min="0" step="1000" required>
                @error('tarif_harian')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                       value="{{ old('tanggal_masuk', $plotting->tanggal_masuk?->format('Y-m-d')) }}">
                @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Tanggal Keluar <small class="text-muted">(isi jika selesai)</small></label>
                <input type="date" name="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror"
                       value="{{ old('tanggal_keluar', $plotting->tanggal_keluar?->format('Y-m-d')) }}">
                @error('tanggal_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('admin.plottings.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
