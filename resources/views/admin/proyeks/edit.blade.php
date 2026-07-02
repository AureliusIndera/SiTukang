@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
<h4 class="mb-3"><i class="bi bi-pencil-square"></i> Edit Proyek</h4>

<div class="card p-3 p-md-4">
    <form method="POST" action="{{ route('admin.proyeks.update', $proyek) }}">
        @csrf
        @method('PUT')
        @include('admin.proyeks._form')

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('admin.proyeks.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
