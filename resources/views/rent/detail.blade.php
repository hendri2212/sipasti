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
        <h1 class="display-6 fw-bold text-primary">Penggunaan Aset</h1>
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
                    <small class="text-muted">Dari</small>
                    <h5 class="fw-bold mb-1">{{ $rental->institution->name }}</h5>
                </div>
                <div class="d-flex flex-column mb-3">
                    <small class="text-muted">Nama Aset</small>
                    <h5 class="fw-bold mb-1">{{ $rental->asset->name }}</h5>
                </div>
                <div class="d-flex flex-column mb-3">
                    <small class="text-muted">Perihal</small>
                    <h5 class="fw-light mb-1">{{ $rental->regarding }}</h5>
                </div>
                {{-- <small for="daterange" class="text-muted">Periode (Mulai & Selesai)</small> --}}
                <form action="{{ route('rent.update', $rental->id) }}" method="POST" class="flex-fill mb-0" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- <input
                        type="text"
                        id="daterange"
                        name="daterange"
                        class="form-control"
                        placeholder="Pilih tanggal & waktu"
                        value="{{ old('daterange', optional($rental->start_at)->format('Y-m-d H:i') . ' to ' . optional($rental->end_at)->format('Y-m-d H:i')) }}"
                    > --}}
                    
                    <div class="row g-2 align-items-end mb-2">
                        <div class="col">
                            <label for="start_at" class="form-label small text-muted">Mulai</label>
                            <input
                                type="datetime-local"
                                name="start_at"
                                id="start_at"
                                class="form-control"
                                value="{{ old('start_at', optional($rental->start_at)->format('Y-m-d\\TH:i')) }}"
                                @if($rental->start_at || $rental->status == 'waiting') disabled @endif
                            >
                        </div>
                        <div class="col">
                            <label for="end_at" class="form-label small text-muted">Selesai</label>
                            <input
                                type="datetime-local"
                                name="end_at"
                                id="end_at"
                                class="form-control"
                                value="{{ old('end_at', optional($rental->end_at)->format('Y-m-d\\TH:i')) }}"
                                @if($rental->end_at || $rental->status == 'waiting') disabled @endif
                            >
                        </div>
                    </div>
                    
                    {{-- Surat Rekomendasi jika dibutuhkan dan admin --}}
                    @if($rental->recommendation && auth()->user()->role == 'admin')
                        <div class="mb-3">
                            <label for="recommendation_letter" class="form-label">Upload Surat Rekomendasi</label>
                            <input type="file" class="form-control" name="recommendation_letter" id="recommendation_letter" accept=".pdf,.jpg,.jpeg,.png">
                            @error('recommendation_letter')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    @if($rental->status == 'process' && in_array(auth()->user()->role, ['admin']) && $rental->start_at == null)
                        <div class="d-flex justify-content-end mt-3">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-primary">Terima</button>
                                <a href="{{ route('rent.cancel', $rental->id) }}" class="btn btn-danger">Tolak</a>
                            </div>
                        </div>
                    @endif
                </form>
                @if($rental->status == 'waiting' && in_array(auth()->user()->role, ['super_admin']))
                    <div class="d-flex justify-content-end mt-3">
                        {{-- <button class="btn btn-danger flex-fill">Tolak</button> --}}
                        <a href="{{ route('rent.approve', $rental->id) }}" class="btn btn-info col-4">Setujui</a>
                    </div>
                @endif
                @if($rental->status == 'finish' && in_array(auth()->user()->role, ['admin']))
                    <div class="d-flex justify-content-end mt-3">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('rent.change', $rental->id) }}" class="btn btn-warning">Ganti</a>
                            <a href="{{ route('rent.cancel', $rental->id) }}" class="btn btn-danger">Batalkan</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card bg-white shadow-sm rounded-3 border-0 mt-3">
            <div class="card-body p-3">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white shadow-sm rounded-3 border-0">
            <div class="card-body p-3">
                {{-- @if($rental->photo)
                    <img src="{{ asset('storage/' . $rental->photo) }}" 
                        alt="Scan Surat" 
                        class="img-fluid">
                @else
                    <div class="border rounded p-5 text-muted">Tidak ada foto.</div>
                @endif --}}
                @if($rental->photo)
                    @php
                        $extension = pathinfo($rental->photo, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $rental->photo) }}" 
                            alt="Scan Surat" 
                            class="img-fluid">
                    @elseif(strtolower($extension) === 'pdf')
                        <iframe src="{{ asset('storage/' . $rental->photo) }}" 
                                width="100%" 
                                height="600px" 
                                style="border: none;"></iframe>
                    @else
                        <div class="border rounded p-5 text-muted">Format file tidak didukung.</div>
                    @endif
                @else
                    <div class="border rounded p-5 text-muted">Tidak ada file yang diunggah.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: {
                url: '{{ route('rent.events', $rental->asset_id) }}',
                method: 'GET',
            }
        })
        calendar.render()
    })
</script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#daterange", {
            mode: "range",          // enable range selection
            enableTime: true,       // tampilkan pilihan jam
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            plugins: [new rangePlugin({ input: "#daterange" })]
        });
    });
</script> --}}