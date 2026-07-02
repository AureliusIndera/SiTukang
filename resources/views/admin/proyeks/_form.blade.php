<div class="row g-3">
    <div class="col-12 col-md-6">
        <label class="form-label">Nama Proyek</label>
        <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror"
               value="{{ old('nama_proyek', $proyek->nama_proyek ?? '') }}" required>
        @error('nama_proyek')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label">Lokasi</label>
        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
               value="{{ old('lokasi', $proyek->lokasi ?? '') }}">
        @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Status Proyek</label>
        <select name="status_proyek" class="form-select @error('status_proyek') is-invalid @enderror" required>
            @foreach(['pending' => 'Menunggu', 'aktif' => 'Aktif', 'selesai' => 'Selesai'] as $val => $label)
                <option value="{{ $val }}" {{ old('status_proyek', $proyek->status_proyek ?? '') == $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status_proyek')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
               value="{{ old('tanggal_mulai', isset($proyek) && $proyek->tanggal_mulai ? $proyek->tanggal_mulai->format('Y-m-d') : '') }}">
        @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
               value="{{ old('tanggal_selesai', isset($proyek) && $proyek->tanggal_selesai ? $proyek->tanggal_selesai->format('Y-m-d') : '') }}">
        @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
