<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SiTukang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 2rem 0;
        }
        .register-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .role-card {
            cursor: pointer;
            border: 2px solid #dee2e6;
            border-radius: 0.75rem;
            transition: all 0.2s;
        }
        .role-card:hover {
            border-color: #0d6efd;
            background-color: #f0f4ff;
        }
        .role-card.selected {
            border-color: #0d6efd;
            background-color: #e7efff;
        }
        .role-card input[type="radio"] {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card register-card">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <i class="bi bi-tools fs-1 text-primary"></i>
                            <h4 class="mt-2 mb-0 fw-bold">Daftar ke SiTukang</h4>
                            <p class="text-muted small mb-0">Buat akun baru untuk mengakses sistem</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong><i class="bi bi-exclamation-triangle-fill"></i> Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf

                            {{-- Pilihan Role --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Daftar Sebagai</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="role-card d-block p-3 text-center {{ old('role') == 'tukang' ? 'selected' : '' }}"
                                               for="role_tukang">
                                            <input type="radio" name="role" id="role_tukang"
                                                   value="tukang" {{ old('role') == 'tukang' ? 'checked' : '' }}>
                                            <i class="bi bi-person-gear fs-2 text-success d-block mb-1"></i>
                                            <span class="fw-semibold">Tukang</span>
                                            <div class="small text-muted">Pekerja lapangan</div>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="role-card d-block p-3 text-center {{ old('role') == 'mandor' ? 'selected' : '' }}"
                                               for="role_mandor">
                                            <input type="radio" name="role" id="role_mandor"
                                                   value="mandor" {{ old('role') == 'mandor' ? 'checked' : '' }}>
                                            <i class="bi bi-person-badge fs-2 text-primary d-block mb-1"></i>
                                            <span class="fw-semibold">Mandor</span>
                                            <div class="small text-muted">Pengawas lapangan</div>
                                        </label>
                                    </div>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Akun Login --}}
                            <h6 class="text-muted mb-3"><i class="bi bi-key"></i> Akun Login</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required placeholder="Nama lengkap kamu">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required placeholder="email@contoh.com">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required placeholder="Min. 6 karakter">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control" required placeholder="Ulangi password">
                                </div>
                            </div>

                            {{-- Profil Tukang --}}
                            <div id="tukangFields" class="d-none">
                                <hr>
                                <h6 class="text-muted mb-3"><i class="bi bi-person-gear"></i> Profil Tukang</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-12">
                                        <label class="form-label">Nama Tukang</label>
                                        <input type="text" name="nama_tukang"
                                               class="form-control @error('nama_tukang') is-invalid @enderror"
                                               value="{{ old('nama_tukang') }}" placeholder="Nama lengkap">
                                        @error('nama_tukang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">No. HP <small class="text-muted">(opsional)</small></label>
                                        <input type="text" name="no_hp_tukang" class="form-control"
                                               value="{{ old('no_hp_tukang') }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Skill <small class="text-muted">(opsional)</small></label>
                                        <input type="text" name="skill" class="form-control"
                                               value="{{ old('skill') }}" placeholder="Contoh: Tukang Batu">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat <small class="text-muted">(opsional)</small></label>
                                        <textarea name="alamat_tukang" class="form-control" rows="2"
                                                  placeholder="Alamat lengkap">{{ old('alamat_tukang') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Profil Mandor --}}
                            <div id="mandorFields" class="d-none">
                                <hr>
                                <h6 class="text-muted mb-3"><i class="bi bi-person-badge"></i> Profil Mandor</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-12">
                                        <label class="form-label">Nama Mandor</label>
                                        <input type="text" name="nama_mandor"
                                               class="form-control @error('nama_mandor') is-invalid @enderror"
                                               value="{{ old('nama_mandor') }}" placeholder="Nama lengkap">
                                        @error('nama_mandor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">No. HP <small class="text-muted">(opsional)</small></label>
                                        <input type="text" name="no_hp_mandor" class="form-control"
                                               value="{{ old('no_hp_mandor') }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat <small class="text-muted">(opsional)</small></label>
                                        <textarea name="alamat_mandor" class="form-control" rows="2"
                                                  placeholder="Alamat lengkap">{{ old('alamat_mandor') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                <i class="bi bi-person-plus"></i> Daftar Sekarang
                            </button>
                        </form>

                        <p class="text-center text-muted small mt-3 mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-decoration-none">Masuk di sini</a>
                        </p>

                    </div>
                </div>

                <p class="text-center text-white-50 small mt-3 mb-0">
                    &copy; {{ date('Y') }} SiTukang
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle field profil sesuai role yang dipilih
        function toggleFields() {
            const tukang = document.getElementById('role_tukang').checked;
            const mandor = document.getElementById('role_mandor').checked;

            document.getElementById('tukangFields').classList.toggle('d-none', !tukang);
            document.getElementById('mandorFields').classList.toggle('d-none', !mandor);
        }

        // Highlight role card yang dipilih
        function highlightCard() {
            document.querySelectorAll('.role-card').forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                card.classList.toggle('selected', radio.checked);
            });
        }

        document.querySelectorAll('input[name="role"]').forEach(el => {
            el.addEventListener('change', function() {
                toggleFields();
                highlightCard();
            });
        });

        // Jalankan saat page load (untuk old() value saat validasi gagal)
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();
            highlightCard();
        });
    </script>
</body>
</html>
