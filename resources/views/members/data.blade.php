@extends('welcome')

@section('content')
<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <h1 class="display-6 fw-bold text-success">Data Pemohon</h1>
        <p class="fs-4 mb-0">Data pemohon penggunaan aset DISPARPORA Kotabaru</p>
    </div>
</div>
<div class="row g-4">
    @foreach($members as $member)
        <div class="col-12 col-sm-4 col-md-3 col-lg-2">
            <div class="card h-100 shadow-sm">
                <img src="{{ $member->profile_photo_url ?? ('https://ui-avatars.com/api/?name='.urlencode($member->name).'&size=150') }}" 
                     class="card-img-top" 
                     alt="{{ $member->name }}">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">{{ $member->name }}</h5>
                    <p class="mb-0">
                        <small>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D+/', '', $member->phone)) }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                {{ $member->phone }}
                            </a>
                        </small>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection