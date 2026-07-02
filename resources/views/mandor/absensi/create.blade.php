@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
<h4 class="mb-3"><i class="bi bi-clipboard-check"></i> Input Absensi</h4>

{{-- STEP 1: Pilih Proyek & Tanggal --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('mandor.absensi.create') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-6">
            <label class="form-label">Proyek</label>
            <select name="proyek_id" class="form-select" required>
                <option value="">-- Pilih Proyek --</option>
                @foreach($proyeks as $p)
                    <option value="{{ $p->id }}" {{ $proyek && $proyek->id == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_proyek }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" max="{{ now()->toDateString() }}" required>
        </div>
        <div class="col-12 col-md-2">
            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="bi bi-search"></i> Tampilkan
            </button>
        </div>
    </form>
</div>

{{-- STEP 2: Daftar Tukang untuk Diisi Statusnya --}}
@if($proyek)
    @if($tukangs->isEmpty())
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i>
            Belum ada tukang yang di-plot ke proyek <strong>{{ $proyek->nama_proyek }}</strong>.
            Hubungi admin untuk melakukan plotting tukang terlebih dahulu.
        </div>
    @else
        <form method="POST" action="{{ route('mandor.absensi.store') }}">
            @csrf
            <input type="hidden" name="proyek_id" value="{{ $proyek->id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="card p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div>
                        <strong>{{ $proyek->nama_proyek }}</strong>
                        <div class="text-muted small">
                            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="setAllStatus('Hadir')">
                        <i class="bi bi-check-all"></i> Tandai Semua Hadir
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle table-responsive-card">
                        <thead>
                            <tr>
                                <th>Nama Tukang</th>
                                <th>Skill</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tukangs as $index => $tukang)
                                @php $existing = $absensiExisting->get($tukang->id); @endphp
                                <tr>
                                    <td data-label="Nama">{{ $tukang->nama_tukang }}</td>
                                    <td data-label="Skill">{{ $tukang->skill ?? '-' }}</td>
                                    <td data-label="Status">
                                        <input type="hidden" name="absensi[{{ $index }}][tukang_id]" value="{{ $tukang->id }}">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @foreach(['Hadir' => 'success', 'Absen' => 'danger', 'Izin' => 'warning'] as $status => $color)
                                                <input type="radio" class="btn-check status-radio" autocomplete="off"
                                                       name="absensi[{{ $index }}][status]"
                                                       id="status_{{ $index }}_{{ $status }}"
                                                       value="{{ $status }}"
                                                       data-status="{{ $status }}"
                                                       {{ ($existing->status ?? 'Hadir') == $status ? 'checked' : '' }}
                                                       required>
                                                <label class="btn btn-outline-{{ $color }}" for="status_{{ $index }}_{{ $status }}">
                                                    {{ $status }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td data-label="Keterangan">
                                        <input type="text" name="absensi[{{ $index }}][keterangan]" class="form-control form-control-sm"
                                               value="{{ $existing->keterangan ?? '' }}" placeholder="Opsional">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($absensiExisting->isNotEmpty())
                    <div class="alert alert-info small mb-0 mt-2">
                        <i class="bi bi-info-circle"></i>
                        Sudah ada absensi tersimpan untuk tanggal ini. Menyimpan ulang akan
                        <strong>memperbarui</strong> data yang sudah ada.
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Absensi
            </button>
        </form>
    @endif
@else
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Pilih proyek dan tanggal terlebih dahulu untuk menampilkan daftar tukang.
    </div>
@endif
@endsection

@push('scripts')
<script>
    function setAllStatus(status) {
        document.querySelectorAll('.status-radio[data-status="' + status + '"]').forEach(function (el) {
            el.checked = true;
        });
    }
</script>
@endpush
