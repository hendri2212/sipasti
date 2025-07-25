@extends('welcome')

@section('content')
    <div class="mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid p-3">
            <h1 class="display-6 fw-bold text-success">Penggunaan Aset</h1>
            <p class="fs-4 mb-0">Detail penggunaan aset DISPARPORA Kotabaru</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card bg-white shadow-sm rounded-3 border-0">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-1 text-secondary me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $rental->member->name }}</h6>
                                <small class="text-muted">
                                    @php
                                        $rawPhone = $rental->member->phone;
                                        $waPhone = preg_replace('/^0/', '62', $rawPhone);
                                    @endphp
                                    <a href="https://wa.me/{{ $waPhone }}" target="_blank">
                                        {{ $rawPhone }}
                                    </a>
                                </small>
                            </div>
                        </div>
                        <span class="py-2 px-3 rounded-pill badge bg-{{
                            $rental->status == 'waiting' ? 'secondary' :
                            ($rental->status == 'process' ? 'primary' :
                            ($rental->status == 'finish' ? 'success' : 'danger'))
                        }}">
                            {{ ucfirst($rental->status) }}
                        </span>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <small class="text-muted">From</small>
                        <h5 class="fw-bold mb-1">{{ $rental->institution->name }}</h5>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <small class="text-muted">Asset Name</small>
                        <h5 class="fw-bold mb-1">{{ $rental->asset->name }}</h5>
                        {{-- <p class="text-muted mb-0">Jumat, 25 Juli 2025</p> --}}
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <small class="text-muted">Date</small>
                        <dd class="col-sm-8">{{ $rental->created_at->format('Y-m-d') }}</dd>
                        <h5 class="fw-bold mb-1">
                            @if($rental->start_at)
                                <dt class="col-sm-4">Mulai</dt>
                                <dd class="col-sm-8">{{ $rental->start_at->format('Y-m-d H:i') }}</dd>
                            @endif

                            @if($rental->end_at)
                                <dt class="col-sm-4">Selesai</dt>
                                <dd class="col-sm-8">{{ $rental->end_at->format('Y-m-d H:i') }}</dd>
                            @endif
                        </h5>
                    </div>
                    @if($rental->status == 'waiting' && in_array(auth()->user()->role, ['super_admin', 'admin']))
                    <div class="d-grid gap-3 d-flex justify-content-between mt-4">
                        <button class="btn btn-danger flex-fill">Tolak</button>
                        <a href="{{ route('rent.approve', $rental->id) }}" class="btn btn-success flex-fill">Setujui</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-white shadow-sm rounded-3 border-0">
                <div class="card-body p-3">
                    {{-- <h5 class="fw-bold mb-3">Keterangan</h5> --}}
                    @if($rental->photo)
                        <img src="{{ asset('storage/' . $rental->photo) }}" 
                            alt="Scan Surat" 
                            class="img-fluid">
                    @else
                        <div class="border rounded p-5 text-muted">Tidak ada foto.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
