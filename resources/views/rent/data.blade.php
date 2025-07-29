@extends('welcome')

@section('content')
<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <h1 class="display-6 fw-bold text-primary">Penggunaan Aset</h1>
        <p class="fs-4 mb-0">Data penggunaan aset DISPARPORA Kotabaru</p>
    </div>
</div>
<div class="d-flex flex-wrap gap-2 mb-4" id="statusFilters">
    <button type="button" class="btn btn-sm btn-outline-success" data-filter="all">Semua</button>
    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="waiting">Waiting</button>
    <button type="button" class="btn btn-sm btn-outline-primary" data-filter="process">Process</button>
    <button type="button" class="btn btn-sm btn-outline-dark" data-filter="finish">Finish</button>
    <button type="button" class="btn btn-sm btn-outline-danger" data-filter="cancel">Cancel</button>
</div>
<div class="row g-4" id="cardsGrid">
    @foreach($rentalAssets as $rental)
    <div class="col-12 col-md-6 col-lg-4" data-status="{{ $rental->status }}">
        @php
            $canClick = ($rental->status === 'waiting' && auth()->user()->role === 'super_admin')
                        || (in_array($rental->status, ['process','finish','cancel']) && in_array(auth()->user()->role, ['super_admin','admin']));
        @endphp
        @if($canClick)
            <a href="{{ route('rent.show', $rental->id) }}" class="text-decoration-none text-reset">
        @endif
            <div class="card h-100 border-info rounded-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-info">{{ $rental->member->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $rental->institution->name }}</h6>
                            <p class="mb-1"><strong>WhatsApp:</strong> {{ $rental->member->phone }}</p>
                            <p class="mb-1"><strong>Aset:</strong> {{ $rental->asset->name }}</p>
                            <p class="mb-0">
                                <small class="text-muted">
                                    Peminjaman:
                                    @if($rental->start_at && $rental->end_at)
                                        {{ $rental->start_at->format('Y-m-d H:i') }} - {{ $rental->end_at->format('Y-m-d H:i') }}
                                    @elseif($rental->start_at)
                                        Mulai {{ $rental->start_at->format('Y-m-d H:i') }}
                                    @else
                                        {{ $rental->created_at->format('Y-m-d') }}
                                    @endif
                                </small>
                            </p>
                        </div>
                        @php
                            $extension = $rental->photo ? pathinfo($rental->photo, PATHINFO_EXTENSION) : null;
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']);
                            $thumbnailUrl = $isImage ? asset('storage/' . $rental->photo) : 'https://placehold.co/100x150?text=PDF';
                        @endphp
                        <img src="{{ $thumbnailUrl }}"
                            class="rounded border border-dark-subtle ms-3" alt="{{ $rental->member->name }}" width="100" height="150">
                    </div>
                </div>
            </div>
        @if($canClick)
            </a>
        @endif
    </div>
    @endforeach
</div>
<script>
(function () {
    const buttons = document.querySelectorAll('#statusFilters [data-filter]');
    const cards = document.querySelectorAll('#cardsGrid [data-status]');

    function filterCards(filter) {
        cards.forEach(card => {
            const match = filter === 'all' || card.getAttribute('data-status') === filter;
            card.classList.toggle('d-none', !match);
        });
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            // toggle active state
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            filterCards(btn.getAttribute('data-filter'));
        });
    });

    // Initial filter on page load
    const activeBtn = document.querySelector('#statusFilters [data-filter].active');
    if (activeBtn) {
        filterCards(activeBtn.getAttribute('data-filter'));
    }
})();
</script>
<a href="{{ url('/rent/form') }}"
    class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4 shadow fab-add d-flex align-items-center justify-content-center"
    style="width:60px;height:60px;z-index:1050;">
    <i class="bi bi-plus-lg fs-3"></i>
    <span class="visually-hidden">Tambah</span>
</a>
@endsection