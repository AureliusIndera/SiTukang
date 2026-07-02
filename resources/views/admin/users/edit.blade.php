@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<h4 class="mb-3"><i class="bi bi-pencil-square"></i> Edit User</h4>

<div class="card p-3 p-md-4">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <h6 class="text-muted mb-3"><i class="bi bi-key"></i> Akun Login</h6>
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label">Nama Akun</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>
            <div class="col-12">
                <label class="form-label">Role</label>
                <input type="text" class="form-control" value="{{ $user->role_label }}" disabled>
                <small class="text-muted">Role tidak dapat diubah setelah akun dibuat.</small>
            </div>
        </div>

        <hr class="my-4">

        @if($user->role === 'mandor')
            <h6 class="text-muted mb-3"><i class="bi bi-person-badge"></i> Profil Mandor</h6>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Nama Mandor</label>
                    <input type="text" name="nama_mandor" class="form-control @error('nama_mandor') is-invalid @enderror" value="{{ old('nama_mandor', $user->mandor->nama_mandor) }}" required>
                    @error('nama_mandor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp_mandor" class="form-control" value="{{ old('no_hp_mandor', $user->mandor->no_hp) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat_mandor" class="form-control" rows="2">{{ old('alamat_mandor', $user->mandor->alamat) }}</textarea>
                </div>
            </div>
        @elseif($user->role === 'tukang')
            <h6 class="text-muted mb-3"><i class="bi bi-person-gear"></i> Profil Tukang</h6>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Nama Tukang</label>
                    <input type="text" name="nama_tukang" class="form-control @error('nama_tukang') is-invalid @enderror" value="{{ old('nama_tukang', $user->tukang->nama_tukang) }}" required>
                    @error('nama_tukang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp_tukang" class="form-control" value="{{ old('no_hp_tukang', $user->tukang->no_hp) }}">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Skill</label>
                    <input type="text" name="skill" class="form-control" value="{{ old('skill', $user->tukang->skill) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat_tukang" class="form-control" rows="2">{{ old('alamat_tukang', $user->tukang->alamat) }}</textarea>
                </div>
            </div>
        @endif

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
