<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SiTukang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .nav-link.active {
            font-weight: 600;
            color: #fff !important;
            border-bottom: 2px solid #ffc107;
        }
        table th {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #6c757d;
        }
        @media (max-width: 576px) {
            .table-responsive-card thead { display: none; }
            .table-responsive-card tr {
                display: block;
                margin-bottom: 0.75rem;
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                padding: 0.5rem;
            }
            .table-responsive-card td {
                display: flex;
                justify-content: space-between;
                border: none;
                padding: 0.35rem 0.5rem;
            }
            .table-responsive-card td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6c757d;
                margin-right: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <main class="container py-4">
        @include('partials.alerts')
        @yield('content')
    </main>

    <footer class="text-center text-muted py-4 small">
        &copy; {{ date('Y') }} SiTukang &mdash; Sistem Penggajian Tukang Proyek Konstruksi
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
