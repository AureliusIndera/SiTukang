@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0"><i class="bi bi-people"></i> Kelola User</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
</div>

<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2">
        <div class="col-12 col-md-4">
            <select name="role" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="mandor" {{ request('role') == 'mandor' ? 'selected' : '' }}>Mandor</option>
                <option value="tukang" {{ request('role') == 'tukang' ? 'selected' : '' }}>Tukang</option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}">
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>No. HP</th>
                    <th>Skill</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td data-label="Nama">
                        {{ $user->mandor->nama_mandor ?? $user->tukang->nama_tukang ?? $user->name }}
                    </td>
                    <td data-label="Email">{{ $user->email }}</td>
                    <td data-label="Role">
                        <span class="badge bg-{{ $user->role == 'mandor' ? 'info' : 'success' }}">
                            {{ $user->role_label }}
                        </span>
                    </td>
                    <td data-label="No. HP">{{ $user->mandor->no_hp ?? $user->tukang->no_hp ?? '-' }}</td>
                    <td data-label="Skill">{{ $user->tukang->skill ?? '-' }}</td>
                    <td data-label="Aksi" class="text-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $users->links() }}</div>
</div>
@endsection
