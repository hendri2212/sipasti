@extends('welcome')

@section('content')
    <div class="px-3 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-3">
            <h1 class="display-6 fw-bold text-primary">Peminjaman Aset</h1>
            <p class="fs-4">Input Form Data Peminjaman Aset</p>
        </div>
    </div>
    <div class="col-md-6">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <form action="{{ route('rent.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm rounded-3 p-4">
            @csrf
            <div class="form-floating mb-2">
                <input type="text" name="letter_number" value="{{ old('letter_number') }}" class="form-control @error('letter_number') is-invalid @enderror" required>
                <label class="form-label">Letter Number</label>
                @error('letter_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-floating mb-3">
                <input type="date" name="letter_date" value="{{ old('letter_date') }}" class="form-control @error('letter_date') is-invalid @enderror" required>
                <label class="form-label">Letter Date</label>
                @error('letter_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-floating mb-2">
                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                <label class="form-label">Full Name</label>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-floating mb-2">
                <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                <label class="form-label">Whatsapp Number</label>
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-floating mb-2">
                <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                <label class="form-label">Address</label>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-2">
                {{-- <label class="form-label">Institution</label> --}}
                <select name="institution_id" id="institution_id" class="form-select select2 @error('institution_id') is-invalid @enderror" data-placeholder="-- Pilih Instansi --" required>
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($institutions as $ins)
                        <option value="{{ $ins->id }}" @selected(old('institution_id')==$ins->id)>{{ $ins->name }}</option>
                    @endforeach
                </select>
                @error('institution_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                {{-- <label class="form-label">Asset</label> --}}
                <select name="asset_id" id="asset_id" class="form-select form-control-lg select2 @error('asset_id') is-invalid @enderror" data-placeholder="-- Pilih Aset --" required>
                    <option value="">-- Pilih Aset --</option>
                    @foreach($assets as $a)
                        <option value="{{ $a->id }}" @selected(old('asset_id')==$a->id)>{{ $a->name }}</option>
                    @endforeach
                </select>
                @error('asset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
    
            <div class="mb-3">
                {{-- <label class="form-label">Foto / Bukti Surat Permohoman</label> --}}
                {{-- Input kamera (mobile akan memunculkan kamera) --}}
                <input type="file"
                       name="photo"
                       id="photo"
                       accept="image/*,application/pdf"
                       class="form-control @error('photo') is-invalid @enderror"
                       required>
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Gunakan kamera belakang untuk foto langsung.</small>
            </div>
    
            <div class="text-end">
                <button class="btn btn-info">Ajukan</button>
            </div>
        </form>
    </div>
    <script>
// Customized Select2 for institution with tagging and AJAX save
document.addEventListener('DOMContentLoaded', function () {
    // Institution select2 with tagging
    $('#institution_id').select2({
        width: '100%',
        tags: true,
        allowClear: true,
        placeholder: function() {
            return $(this).data('placeholder') || '-- Pilih --';
        },
        createTag: function(params) {
            var term = $.trim(params.term);
            if (!term) {
                return null;
            }
            return {
                id: term,
                text: term,
                newTag: true
            };
        },
        templateResult: function(data) {
            if (data.loading) return data.text;
            var $container = $('<span></span>').text(data.text);
            if (data.newTag) {
                $container.append(
                    ' <button type="button" class="btn btn-sm btn-outline-primary ms-2 add-institution" data-name="' + data.text + '">Simpan</button>'
                );
            }
            return $container;
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    }).on('select2:select', function(e) {
        var data = e.params.data;
        if (data.newTag) {
            // AJAX request to save new institution
            $.ajax({
                url: '{{ route("institutions.store") }}',
                type: 'POST',
                data: {
                    name: data.text,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Replace temporary option with real one
                    var newOption = new Option(response.name, response.id, true, true);
                    $('#institution_id').find(':selected').replaceWith(newOption).trigger('change');
                },
                error: function() {
                    alert('Gagal menyimpan instansi baru');
                }
            });
        }
    });

    // Initialize asset select2 normally
    $('#asset_id').select2({
        width: '100%',
        allowClear: true,
        placeholder: function() {
            return $(this).data('placeholder') || '-- Pilih Aset --';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('photo');
    if (photoInput) {
        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.size > 5 * 1024 * 1024) { // > 5MB
                alert("Ukuran file tidak boleh lebih dari 5MB.");
                this.value = ""; // reset input
            }
        });
    }
});
</script>
@endsection