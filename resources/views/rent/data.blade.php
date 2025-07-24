@extends('welcome')

@section('content')
{{-- <main class="container py-4"> --}}
    <div class="px-3 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-3">
            <h1 class="display-6 fw-bold text-success">Penggunaan Aset</h1>
            <p class="fs-4">Data penggunaan aset DISPARPORA Kotabaru</p>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-4" id="statusFilters">
        <button type="button" class="btn btn-sm btn-outline-success active" data-filter="all">Semua</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="waiting">Waiting</button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-filter="process">Process</button>
        <button type="button" class="btn btn-sm btn-outline-dark" data-filter="finish">Finish</button>
        <button type="button" class="btn btn-sm btn-outline-danger" data-filter="cancel">Cancel</button>
    </div>
    <div class="row g-4" id="cardsGrid">
        <!-- Card for each pelanggan -->
        <div class="col-12 col-md-6 col-lg-4" data-status="cancel">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-success">Alice Saputra</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Dinas Pariwisata Kotabaru</h6>
                            <p class="mb-1"><strong>WhatsApp:</strong> 081234567890</p>
                            <p class="mb-1"><strong>Aset:</strong> Lapangan Siring Laut</p>
                            <p class="mb-0"><small class="text-muted">Peminjaman: 2025-01-10</small></p>
                        </div>
                        <img src="https://picsum.photos/seed/alice-saputra/100/150"
                             class="rounded ms-3"
                             alt="Alice Saputra"
                             width="100" height="150">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4" data-status="process">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-success">Budi Santoso</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Dinas Pemuda & Olahraga</h6>
                            <p class="mb-1"><strong>WhatsApp:</strong> 081298765432</p>
                            <p class="mb-1"><strong>Aset:</strong> Panggung Apung</p>
                            <p class="mb-0"><small class="text-muted">Peminjaman: 2025-01-15</small></p>
                        </div>
                        <img src="https://picsum.photos/seed/budi-santoso/100/150"
                             class="rounded ms-3"
                             alt="Budi Santoso"
                             width="100" height="150">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4" data-status="finish">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-success">Chandra Wijaya</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Dinas Kebudayaan</h6>
                            <p class="mb-1"><strong>WhatsApp:</strong> 081234000001</p>
                            <p class="mb-1"><strong>Aset:</strong> Pantai Gedambaan</p>
                            <p class="mb-0"><small class="text-muted">Peminjaman: 2025-02-01</small></p>
                        </div>
                        <img src="https://picsum.photos/seed/chandra-wijaya/100/150"
                             class="rounded ms-3"
                             alt="Chandra Wijaya"
                             width="100" height="150">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4" data-status="waiting">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-success">Dewi Lestari</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Dinas Lingkungan Hidup</h6>
                            <p class="mb-1"><strong>WhatsApp:</strong> 081234000002</p>
                            <p class="mb-1"><strong>Aset:</strong> Hutan Meranti</p>
                            <p class="mb-0"><small class="text-muted">Peminjaman: 2025-02-05</small></p>
                        </div>
                        <img src="https://picsum.photos/seed/dewi-lestari/100/150"
                             class="rounded ms-3"
                             alt="Dewi Lestari"
                             width="100" height="150">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4" data-status="process">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-success">Eka Prasetya</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Dinas Pertanian</h6>
                            <p class="mb-1"><strong>WhatsApp:</strong> 081234000003</p>
                            <p class="mb-1"><strong>Aset:</strong> Tumpang Dua</p>
                            <p class="mb-0"><small class="text-muted">Peminjaman: 2025-02-10</small></p>
                        </div>
                        <img src="https://picsum.photos/seed/eka-prasetya/100/150"
                             class="rounded ms-3"
                             alt="Eka Prasetya"
                             width="100" height="150">
                    </div>
                </div>
            </div>
        </div>
        <!-- Repeat similarly for the remaining 8 entries: Chandra Wijaya, Dewi Lestari, Eka Prasetya, Farah Nuraini, Giri Putra, Hana Marlina, Ilham Fauzi, Juwita Handayani -->
    </div>
<script>
    (function() {
        const buttons = document.querySelectorAll('#statusFilters [data-filter]');
        const cards = document.querySelectorAll('#cardsGrid [data-status]');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                // toggle active state
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');
                cards.forEach(card => {
                    const match = filter === 'all' || card.getAttribute('data-status') === filter;
                    card.classList.toggle('d-none', !match);
                });
            });
        });
    })();
</script>
<a href="{{ url('/rent/form') }}"
   class="btn btn-success rounded-circle position-fixed bottom-0 end-0 m-4 shadow fab-add d-flex align-items-center justify-content-center"
   style="width:60px;height:60px;z-index:1050;">
    <i class="bi bi-plus-lg fs-3"></i>
    <span class="visually-hidden">Tambah</span>
</a>
{{-- </main> --}}
@endsection