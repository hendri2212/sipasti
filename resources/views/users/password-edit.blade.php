@extends('welcome')

@section('content')
<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <h1 class="display-6 fw-bold text-primary mb-0">Ubah Password</h1>
        <p class="text-muted mb-0">Informasi akun dan kontak pengguna yang sedang login.</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}" class="card p-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="current_password" class="form-label">Password Saat Ini</label>
        <input id="current_password" type="password" name="current_password" class="form-control" required autocomplete="current-password">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password" minlength="8">
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('profile') }}" class="btn btn-outline-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
@endsection