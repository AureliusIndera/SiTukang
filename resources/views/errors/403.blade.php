<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="text-center">
        <i class="bi bi-shield-lock text-danger" style="font-size: 4rem;"></i>
        <h1 class="display-4 fw-bold mt-3">403</h1>
        <p class="lead text-muted">Anda tidak memiliki akses ke halaman ini.</p>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ url('/') }}" class="btn btn-primary">
            <i class="bi bi-house"></i> Dashboard
        </a>
    </div>
</body>
</html>