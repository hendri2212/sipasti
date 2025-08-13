<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPASTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js"></script>
    <style>
        .nav-link.active {
            position: relative;
        }
        .nav-link.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: rgb(28, 14, 223);
        }
    </style>
</head>

<body class="bg-body-secondary">
    <div class="container py-3">
        <header class="mb-4">
            <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm py-3">
                <div class="container">
                    <img src="{{ asset('sipasti.png') }}" alt="SIPASTI Logo" class="navbar-brand-logo me-2" width="40" height="40">
                    <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">SIPASTI</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav ms-auto mb-2 mb-md-0 align-items-md-center">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('members/data*') ? 'active' : '' }}" href="{{ url('/members/data') }}">Pemohon</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('assets/data*') ? 'active' : '' }}" href="{{ url('/assets/data') }}">Assets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('sectors/data*') ? 'active' : '' }}" href="{{ url('/sectors/data') }}">Bidang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('rent/report') ? 'active' : '' }}" href="{{ url('/rent/report') }}">Laporan</a>
                            </li>
                            @auth
                                @if(auth()->user()->role === 'super_admin')
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('users/role') ? 'active' : '' }}" href="{{ url('/users/role') }}">Role</a>
                                    </li>
                                @endif
                            @endauth
                            {{-- <li class="nav-item"><a class="nav-link" href="#">Users</a></li> --}}
                            <li class="nav-item dropdown ms-md-3">
                                <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img
                                        src="{{ auth()->user()->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name)) }}"
                                        alt="Avatar"
                                        class="rounded-circle me-0"
                                        width="36"
                                        height="36"
                                    >
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/profile') }}">
                                            <i class="bi bi-person me-2"></i> Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        @yield('content')
        @if (session('status'))
          <div class="alert alert-success container mt-3">{{ session('status') }}</div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>