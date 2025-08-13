@extends('welcome')

@section('content')

<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <h1 class="display-6 fw-bold text-primary mb-0">Profil Saya</h1>
        <p class="text-muted mb-0">Informasi akun dan kontak pengguna yang sedang login.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle mb-3" width="120" height="120">
                <h5 class="card-title mb-1">{{ $user->name }}</h5>
                <span class="badge bg-info text-dark text-uppercase">{{ $user->role ?? 'user' }}</span>
                <hr>
                <div class="d-grid gap-2">
                    <a class="btn btn-outline-secondary" href="mailto:{{ $user->email }}">
                        <i class="bi bi-envelope me-2"></i>Email
                    </a>
                    @if($waNumber)
                        <a class="btn btn-outline-success" target="_blank" rel="noopener" href="https://wa.me/{{ $waNumber }}">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white"><strong>Informasi Dasar</strong></div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold">Nama</div>
                            <div class="text-muted">{{ $user->name }}</div>
                        </div>
                        <i class="bi bi-person fs-5 text-secondary"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold">Email</div>
                            <div class="text-muted">{{ $user->email }}</div>
                        </div>
                        <i class="bi bi-envelope fs-5 text-secondary"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold">Telepon</div>
                            <div class="text-muted">{{ $rawPhone ?: '-' }}</div>
                        </div>
                        <i class="bi bi-telephone fs-5 text-secondary"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold">Instansi</div>
                            <div class="text-muted">{{ optional($user->institution)->name ?: '-' }}</div>
                        </div>
                        <i class="bi bi-building fs-5 text-secondary"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold">Bergabung Sejak</div>
                            <div class="text-muted">{{ optional($user->created_at)->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA</div>
                        </div>
                        <i class="bi bi-calendar-event fs-5 text-secondary"></i>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white"><strong>Keamanan Akun</strong></div>
            <div class="card-body">
                <p class="mb-2 text-muted">Untuk menjaga keamanan akun, gunakan kata sandi yang kuat dan unik.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#" class="btn btn-outline-primary disabled" aria-disabled="true" title="Form ubah profil belum tersedia">
                        <i class="bi bi-pencil-square me-2"></i>Ubah Profil
                    </a>
                    <a href="{{ route('password.edit') }}" class="btn btn-outline-danger">
                        <i class="bi bi-shield-lock me-2"></i>Ubah Password
                    </a>
                </div>
                <small class="d-block mt-2 text-muted">*Tombol sementara nonaktif. Aktifkan ketika rute/form tersedia.</small>
            </div>
        </div>
    </div>
</div>
@endsection