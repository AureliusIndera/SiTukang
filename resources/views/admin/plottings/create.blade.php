@extends('layouts.app')

@section('title', 'Tambah Plotting')

@section('content')
<h4 class="mb-3"><i class="bi bi-diagram-3"></i> Plot Tukang ke Proyek</h4>

<div class="card p-3 p-md-4">
    <form method="POST" action="{{ route('admin.plottings.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label">Tukang</label>
                <select name="tukang_id" class="form-select @error('tukang_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Tukang --</option>
                    @foreach($tukangs as $t)
                        <option value="{{ $t->id }}" {{ old('tukang_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->nama_tukang }} ({{ $t->skill ?? 'Tanpa skill' }})
                        </option>
                    @endforeach
                </select>
                @error('tukang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">Proyek</label>
                <select name="proyek_id" class="form-select @error('proyek_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Proyek --</option>
                    @foreach($proyeks as $p)
                        <option value="{{ $p->id }}" {{ old('proyek_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_proyek }}
                        </option>
                    @endforeach
                </select>
                @error('proyek_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Tarif Harian (Rp)</label>
                <input type="number" name="tarif_harian" class="form-control @error('tarif_harian') is-invalid @enderror"
                       value="{{ old('tarif_harian') }}" min="0" step="1000" required>
                @error('tarif_harian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Tarif khusus untuk tukang ini di proyek ini.</small>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                       value="{{ old('tanggal_masuk', now()->toDateString()) }}">
                @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Tanggal Keluar <small class="text-muted">(opsional)</small></label>
                <input type="date" name="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror"
                       value="{{ old('tanggal_keluar') }}">
                @error('tanggal_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('admin.plottings.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
