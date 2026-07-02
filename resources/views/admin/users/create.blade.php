@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<h4 class="mb-3"><i class="bi bi-person-plus"></i> Tambah User Baru</h4>

<div class="card p-3 p-md-4">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <h6 class="text-muted mb-3"><i class="bi bi-key"></i> Akun Login</h6>
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label">Nama Akun</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Role</label>
                <select name="role" id="roleSelect" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="mandor" {{ old('role') == 'mandor' ? 'selected' : '' }}>Mandor</option>
                    <option value="tukang" {{ old('role') == 'tukang' ? 'selected' : '' }}>Tukang</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <hr class="my-4">

        <!-- Profil Mandor -->
        <div id="mandorFields" class="d-none">
            <h6 class="text-muted mb-3"><i class="bi bi-person-badge"></i> Profil Mandor</h6>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Nama Mandor</label>
                    <input type="text" name="nama_mandor" class="form-control @error('nama_mandor') is-invalid @enderror" value="{{ old('nama_mandor') }}">
                    @error('nama_mandor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp_mandor" class="form-control" value="{{ old('no_hp_mandor') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat_mandor" class="form-control" rows="2">{{ old('alamat_mandor') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Profil Tukang -->
        <div id="tukangFields" class="d-none">
            <h6 class="text-muted mb-3"><i class="bi bi-person-gear"></i> Profil Tukang</h6>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Nama Tukang</label>
                    <input type="text" name="nama_tukang" class="form-control @error('nama_tukang') is-invalid @enderror" value="{{ old('nama_tukang') }}">
                    @error('nama_tukang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp_tukang" class="form-control" value="{{ old('no_hp_tukang') }}">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Skill</label>
                    <input type="text" name="skill" class="form-control" value="{{ old('skill') }}" placeholder="Contoh: Tukang Batu">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat_tukang" class="form-control" rows="2">{{ old('alamat_tukang') }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function toggleProfileFields() {
        const role = document.getElementById('roleSelect').value;
        document.getElementById('mandorFields').classList.toggle('d-none', role !== 'mandor');
        document.getElementById('tukangFields').classList.toggle('d-none', role !== 'tukang');
    }

    document.getElementById('roleSelect').addEventListener('change', toggleProfileFields);
    document.addEventListener('DOMContentLoaded', toggleProfileFields);
</script>
@endpush
