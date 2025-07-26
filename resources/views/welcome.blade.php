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
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
</head>

<body class="bg-body-secondary">
    <div class="container py-3">
        <header class="mb-4">
            <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm py-3">
                <div class="container">
                    <img src="{{ asset('sipasti.png') }}" alt="SIPASTI Logo" class="navbar-brand-logo me-2" width="40" height="40">
                    <a class="navbar-brand fw-bold text-success" href="{{ url('/') }}">SIPASTI</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav ms-auto mb-2 mb-md-0 align-items-md-center">
                            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/members/data') }}">Members</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/assets/data') }}">Assets</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/sectors/data') }}">Bidang</a></li>
                            @auth
                                @if(auth()->user()->role === 'super_admin')
                                    <li class="nav-item"><a class="nav-link" href="{{ url('/users/role') }}">Role</a></li>
                                @endif
                            @endauth
                            {{-- <li class="nav-item"><a class="nav-link" href="#">Users</a></li> --}}
                            <li class="nav-item ms-md-3">
                                <a href="{{ route('logout') }}"
                                   class="btn btn-danger btn-sm px-3 d-md-inline-flex align-items-center"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        @yield('content')
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>