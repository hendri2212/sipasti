@extends('welcome')

@section('content')
    <div class="px-3 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-3">
            <h1 class="display-6 fw-bold text-success">Peminjaman Aset</h1>
            <p class="fs-4">Input Form Data Peminjaman Aset</p>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('rent.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm p-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No. HP</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Instansi</label>
            <select name="institution_id" id="institution_id" class="form-select select2 @error('institution_id') is-invalid @enderror" data-placeholder="-- Pilih Instansi --" required>
                <option value="">-- Pilih Instansi --</option>
                @foreach($institutions as $ins)
                    <option value="{{ $ins->id }}" @selected(old('institution_id')==$ins->id)>{{ $ins->name }}</option>
                @endforeach
            </select>
            @error('institution_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Aset</label>
            <select name="asset_id" id="asset_id" class="form-select select2 @error('asset_id') is-invalid @enderror" data-placeholder="-- Pilih Aset --" required>
                <option value="">-- Pilih Aset --</option>
                @foreach($assets as $a)
                    <option value="{{ $a->id }}" @selected(old('asset_id')==$a->id)>{{ $a->name }}</option>
                @endforeach
            </select>
            @error('asset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Foto / Bukti</label>
            {{-- Input kamera (mobile akan memunculkan kamera) --}}
            <input type="file"
                   name="photo"
                   accept="image/*"
                   capture="environment"
                   class="form-control @error('photo') is-invalid @enderror"
                   required>
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted">Gunakan kamera belakang untuk foto langsung.</small>
        </div>

        <div class="text-end">
            <button class="btn btn-success">Ajukan</button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.select2').select2({
                width: '100%',
                allowClear: true,
                placeholder: function(){ return $(this).data('placeholder') || '-- Pilih --'; }
            });
        });
    </script>
@endsection