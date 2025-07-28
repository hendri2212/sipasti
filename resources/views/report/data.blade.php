
@extends('welcome')
@php use Carbon\Carbon; @endphp

<style>
.print-header {
    display: none;
}
@media print {
    /* Hide everything */
    body * {
        visibility: hidden;
    }
    /* Show print header and table */
    .print-header, .print-header *, .table-responsive, .table-responsive * {
        visibility: visible;
    }
    .print-header {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
    }
    /* Ensure the table occupies full page */
    .table-responsive {
        position: absolute;
        top: 100px;
        left: 0;
        width: 100%;
    }
}
</style>
@section('content')
<div class="print-header">
    <h1 class="h2 mb-1">LAPORAN</h1>
    <h2 class="h5 mb-2">PENGGUNAAN ASSET DISPARPORA KOTABARU</h2>
    <p class="mb-4">
        Periode {{ $start 
            ? Carbon::createFromFormat('Y-m-d', $start)->format('d/m/Y') 
            : '-' }} - {{ $end 
            ? Carbon::createFromFormat('Y-m-d', $end)->format('d/m/Y') 
            : '-' }}
    </p>
</div>
<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <h1 class="display-6 fw-bold text-primary">Laporan</h1>
        <p class="fs-4 mb-0">Data laporan penggunaan aset DISPARPORA Kotabaru.</p>
    </div>
</div>
<form method="GET" action="{{ route('rent.report') }}" class="row g-3 mb-4 align-items-end">
    <div class="col-auto">
        {{-- <label for="start_date" class="form-label">Tanggal Mulai</label> --}}
        <input type="date" id="start_date" name="start_date" class="form-control"
            value="{{ request('start_date') }}">
    </div>
    <div class="col-auto">
        {{-- <label for="end_date" class="form-label">Tanggal Selesai</label> --}}
        <input type="date" id="end_date" name="end_date" class="form-control"
            value="{{ request('end_date') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-info">Filter</button>
    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
    </div>
</form>
<div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Instansi</th>
                        <th scope="col">Aset</th>
                        <th scope="col">Pemohon</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentalAssets as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->institution->name }}</td>
                            <td>{{ $item->asset->name }}</td>
                            <td>{{ $item->member->name }}</td>
                            <td>
                                @if($item->photo)
                                    <a href="{{ Storage::url($item->photo) }}" target="_blank" class="text-decoration-none">Image</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ $item->start_at 
                                    ? $item->start_at->format('d/m/Y') 
                                    : '-' }}
                            </td>
                            <td>{{ ucfirst($item->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection