@extends('welcome')

@section('content')
<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <h1 class="display-6 fw-bold text-primary">Akses Pengguna</h1>
        <p class="fs-4 mb-0">Menejemen hak akses pengguna terhadap aset.</p>
    </div>
</div>

@foreach($users as $user)
    {{-- <div class="mb-3"> --}}
        {{-- <h5 class="fw-bold text-primary">{{ $user->name }} ({{ ucfirst($user->role) }})</h5> --}}
        <h5 class="fw-bold text-info">{{ $user->name }}</h5>
    {{-- </div> --}}
    <ul class="list-group mb-4">
        @foreach($user->assetUsers as $assetUser)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $assetUser->asset->name }}
                {{-- <span class="badge bg-success rounded-pill">{{ $assetUser->created_at->format('d-m-Y') }}</span> --}}
            </li>
        @endforeach
    </ul>
@endforeach
@endsection