<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="bi bi-tools"></i> SiTukang
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people"></i> Kelola User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.proyeks.*') ? 'active' : '' }}" href="{{ route('admin.proyeks.index') }}">
                        <i class="bi bi-building"></i> Proyek
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.absensis.*') ? 'active' : '' }}" href="{{ route('admin.absensis.index') }}">
                        <i class="bi bi-clipboard-data"></i> Rekap Absensi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.plottings.*') ? 'active' : '' }}" href="{{ route('admin.plottings.index') }}">
                        <i class="bi bi-diagram-3"></i> Plotting Tukang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.gajis.*') ? 'active' : '' }}" href="{{ route('admin.gajis.index') }}">
                        <i class="bi bi-cash-stack"></i> Gaji
                    </a>
                </li>
                @elseif(auth()->user()->isMandor())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mandor.dashboard') ? 'active' : '' }}" href="{{ route('mandor.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mandor.absensi.create') ? 'active' : '' }}" href="{{ route('mandor.absensi.create') }}">
                        <i class="bi bi-clipboard-check"></i> Input Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mandor.absensi.index') ? 'active' : '' }}" href="{{ route('mandor.absensi.index') }}">
                        <i class="bi bi-clock-history"></i> Riwayat Absensi
                    </a>
                </li>
                @elseif(auth()->user()->isTukang())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tukang.dashboard') ? 'active' : '' }}" href="{{ route('tukang.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tukang.absensi') ? 'active' : '' }}" href="{{ route('tukang.absensi') }}">
                        <i class="bi bi-calendar-check"></i> Absensi Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tukang.gaji*') ? 'active' : '' }}" href="{{ route('tukang.gaji') }}">
                        <i class="bi bi-cash-coin"></i> Gaji Saya
                    </a>
                </li>
                @endif
                @endauth
            </ul>

            @auth
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name }}
                        <span class="badge bg-secondary">{{ auth()->user()->role_label }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>