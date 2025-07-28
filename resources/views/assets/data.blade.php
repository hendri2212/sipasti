@extends('welcome')

@section('content')
<style>
    /* Remove underline and set elegant font color for FullCalendar headers and dates */
    .fc .fc-col-header-cell-cushion,
    .fc .fc-daygrid-day-number {
        text-decoration: none !important;
        color: #2C3E50 !important;
    }
    /* Ensure day numbers (links) inherit the same styling */
    .fc .fc-daygrid-day-number a {
        text-decoration: none !important;
        color: inherit !important;
    }
</style>
<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <h1 class="display-6 fw-bold text-primary">Data Aset</h1>
        <p class="fs-4 mb-0">Berikut adalah daftar aset DISPARPORA Kotabaru</p>
    </div>
</div>

<div class="row g-4">
    @foreach($assets as $index => $asset)
    <div class="col-12 col-md-6 col-lg-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#assetModal{{ $index }}"
            class="d-block text-decoration-none text-reset h-100">
            <div class="card h-100 border-info shadow-sm">
                <img src="{{ $asset->image }}" class="card-img-top" style="object-fit:cover; height:200px;"
                    alt="{{ $asset->title }}">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ $asset->name }}</h5>
                    <p class="card-text text-muted">{{ $asset->description }}</p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@foreach($assets as $index => $asset)
<div class="modal fade" id="assetModal{{ $index }}" tabindex="-1" aria-labelledby="assetModalLabel{{ $index }}"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assetModalLabel{{ $index }}">{{ $asset->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 d-flex flex-column align-items-center">
                        <img src="{{ $asset->image }}" class="img-fluid rounded mb-3 shadow-sm" alt="{{ $asset->title }}">
                        <p class="text-muted text-center">{{ $asset->description }}</p>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div id="calendar{{ $index }}" style="max-width:100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach($assets as $index => $asset)
<script>
    document.getElementById('assetModal{{ $index }}').addEventListener('shown.bs.modal', function () {
        var calendarEl = document.getElementById('calendar{{ $index }}');
        if (!calendarEl.dataset.initialized) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {
                    url: '{{ route("rent.events", $asset->id) }}',
                    method: 'GET',
                }
            });
            calendar.render();
            calendarEl.dataset.initialized = true;
        }
    });
</script>
@endforeach
@endsection