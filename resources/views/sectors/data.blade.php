@extends('welcome')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
{{-- <main class="container py-4"> --}}
  <div class="mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid p-3">
      <h1 class="display-6 fw-bold text-success">Data Bidang</h1>
      <p class="fs-4 mb-0">Berikut adalah daftar bidang beserta jabatannya:</p>
    </div>
  </div>

  @php
    $fields = [
      ['name'=>'Kepala Dinas','icon'=>'bi-person-badge-fill'],
      ['name'=>'Sekretaris','icon'=>'bi-person-lines-fill'],
      ['name'=>'Kepala Bidang Destinasi Pariwisata','icon'=>'bi-geo-alt-fill'],
      ['name'=>'Kepala Bidang Pertunjukan Event Pariwisata dan Ekraf','icon'=>'bi-easel-fill'],
      ['name'=>'Kepala Bidang Kepemudaan','icon'=>'bi-people-fill'],
      ['name'=>'Kepala Bidang Olahraga','icon'=>'bi-trophy-fill'],
      ['name'=>'Kepala UPT','icon'=>'bi-building-fill'],
    ];
  @endphp

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach($fields as $field)
      <div class="col">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body text-center">
            <i class="{{ $field['icon'] }} fs-1 text-success mb-3"></i>
            <h5 class="card-title fw-semibold">{{ $field['name'] }}</h5>
          </div>
        </div>
      </div>
    @endforeach
  </div>
{{-- </main> --}}
@endsection
