@extends('welcome')

@section('content')
<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css" rel="stylesheet">
<style>
  /* Center-align the day numbers and container */
  .fc .fc-daygrid-day-top {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
  }
  /* Date number styling */
  .fc .fc-daygrid-day-number {
    text-align: center !important;
    display: block;
    width: 100%;
    color: #2c3e50 !important;
    text-decoration: none !important;
  }
  /* Remove underline on dates */
  .fc .fc-daygrid-day-top a {
    text-decoration: none !important;
    color: #2c3e50 !important;
  }
  /* Remove bottom margin on events */
  .fc .fc-daygrid-day-events {
    margin-bottom: 0 !important;
  }
  /* Style weekday header font and remove underline */
  .fc .fc-col-header-cell-cushion {
    color: #34495e !important;
    font-weight: 600 !important;
    text-decoration: none !important;
  }
  .fc .fc-col-header-cell-cushion a {
    text-decoration: none !important;
    color: #34495e !important;
  }
  /* Style disabled past dates */
  .fc .fc-day-disabled {
    background-color: #f0f0f0 !important;
    color: #6c757d !important;
    pointer-events: none !important;
  }
  /* Hide empty event containers to remove blank space in cells */
  .fc .fc-daygrid-day-events,
  .fc .fc-daygrid-day-bottom {
    display: none !important;
  }

  /* Table layout fixed for equal-width columns */
  .fc .fc-daygrid-body table {
    table-layout: fixed !important;
    width: 100%;
  }
  /* Square cells with aspect ratio */
  .fc .fc-daygrid-day-frame {
    display: block !important;
    aspect-ratio: 1 / 1 !important;
    margin-bottom: 0 !important;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- <main class="container py-4"> --}}
    <div class="px-3 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-3">
            <h1 class="display-6 fw-bold text-success">Data Aset</h1>
            <p class="fs-4">Berikut adalah daftar aset yang dapat dipinjam.</p>
        </div>
    </div>
    @php
        $assets = [
            ['title'=>'Lapangan Siring Laut','img'=>'https://picsum.photos/id/1011/400/200','desc'=>'Lapangan serbaguna di tepi laut dengan pemandangan indah.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Panggung Apung','img'=>'https://picsum.photos/id/1012/400/200','desc'=>'Panggung terapung untuk pertunjukan seni dan budaya.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Pantai Gedambaan','img'=>'https://picsum.photos/id/1013/400/200','desc'=>'Pantai berpasir putih dengan fasilitas rekreasi keluarga.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Hutan Meranti','img'=>'https://picsum.photos/id/1015/400/200','desc'=>'Hutan hijau lebat untuk trekking dan edukasi alam.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Tumpang Dua','img'=>'https://picsum.photos/id/1016/400/200','desc'=>'Area pertemuan outdoor bergaya tradisional.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Kolam Renang','img'=>'https://picsum.photos/id/1018/400/200','desc'=>'Kolam renang modern dengan fasilitas lengkap.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Stadion Sepak Bola Bamega','img'=>'https://picsum.photos/id/1020/400/200','desc'=>'Stadion berkapasitas besar untuk pertandingan sepak bola.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'GOR Bulu Tangkis Bamega','img'=>'https://picsum.photos/id/1021/400/200','desc'=>'Gelanggang olahraga bulu tangkis standar internasional.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Basket Indoor','img'=>'https://picsum.photos/id/1024/400/200','desc'=>'Lapangan basket indoor dengan pencahayaan baik.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Lapangan Volly','img'=>'https://picsum.photos/id/1025/400/200','desc'=>'Lapangan voli outdoor dengan permukaan berkualitas.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Gedung Tenis Indoor Gunung Jambangan','img'=>'https://picsum.photos/id/1027/400/200','desc'=>'Tenis indoor dengan atap tertutup dan ventilasi bagus.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Lapangan Futsal Gunung Pemandangan','img'=>'https://picsum.photos/id/1035/400/200','desc'=>'Lapangan futsal outdoor dekat pusat kota.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Lapangan Karate Tugu Nelayan','img'=>'https://picsum.photos/id/1036/400/200','desc'=>'Dojo terbuka untuk latihan karate terbimbing.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']],
            ['title'=>'Lapangan Tenis Meja','img'=>'https://picsum.photos/id/1037/400/200','desc'=>'Arena tenis meja dengan meja standar ITTF.','unavailable'=>['2025-07-23','2025-07-24','2025-08-01','2025-08-05','2025-08-10'],'events'=>['2025-07-23'=>'Event A','2025-07-24'=>'Event B','2025-08-01'=>'Event C','2025-08-05'=>'Event D','2025-08-10'=>'Event E']]
        ];
    @endphp

    <div class="row g-4">
        @foreach($assets as $index => $a)
        <div class="col-12 col-md-6 col-lg-4">
            <a href="#" data-bs-toggle="modal" data-bs-target="#assetModal{{ $index }}" class="d-block text-decoration-none text-reset h-100">
                <div class="card h-100 border-success shadow-sm">
                    <img src="{{ $a['img'] }}" class="card-img-top" style="object-fit:cover; height:200px;" alt="{{ $a['title'] }}">
                    <div class="card-body">
                        <h5 class="card-title text-success">{{ $a['title'] }}</h5>
                        <p class="card-text text-muted">{{ $a['desc'] }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @foreach($assets as $index => $a)
    <div class="modal fade" id="assetModal{{ $index }}" tabindex="-1" aria-labelledby="assetModalLabel{{ $index }}" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="assetModalLabel{{ $index }}">{{ $a['title'] }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {{-- <h6 class="mb-4 text-secondary">Pilih tanggal ketersediaan:</h6> --}}
            <div class="row">
              <div class="col-md-6 d-flex flex-column align-items-center">
                <img src="{{ $a['img'] }}" class="img-fluid rounded mb-3 shadow-sm" alt="{{ $a['title'] }}">
                <p class="text-muted text-center">{{ $a['desc'] }}</p>
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
    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="bookingModalLabel">Form Pemesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="bookingForm">
              <div class="mb-3">
                <label for="bookingName" class="form-label">Nama Pemesan</label>
                <input type="text" class="form-control" id="bookingName" required>
              </div>
              <div class="mb-3">
                <label for="bookingWhatsapp" class="form-label">WhatsApp</label>
                <input type="text" class="form-control" id="bookingWhatsapp" required>
              </div>
              <div class="mb-3">
                <label for="bookingDate" class="form-label">Tanggal</label>
                <input type="text" class="form-control" id="bookingDate" readonly>
              </div>
              <button type="submit" class="btn btn-success">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
<script>
  // Initialize booking modal
  var bookingModalEl = document.getElementById('bookingModal');
  var bookingModal = new bootstrap.Modal(bookingModalEl);
  @foreach($assets as $index => $a)
  (function() {
    var calendar{{ $index }};
    var modalEl = document.getElementById('assetModal{{ $index }}');
    modalEl.addEventListener('shown.bs.modal', function() {
      var calendarEl = document.getElementById('calendar{{ $index }}');
      if (!calendar{{ $index }}) {
        var unavailable = @json($a['unavailable']);
        var bookings = @json($a['bookings'] ?? []);
        var eventsData = @json($a['events'] ?? []);
        calendar{{ $index }} = new FullCalendar.Calendar(calendarEl, {
          locale: 'id',
          initialView: 'dayGridMonth',
          height: 'auto',
          dayCellDidMount: function(info) {
            var d = info.date;
            var year = d.getFullYear();
            var month = String(d.getMonth() + 1).padStart(2, '0');
            var day = String(d.getDate()).padStart(2, '0');
            var dateStr = year + '-' + month + '-' + day;
            var todayStr = '{{ now()->format("Y-m-d") }}';
            // Highlight today's date
            if (dateStr === todayStr) {
              info.el.style.backgroundColor = 'lightyellow';
            } else {
              // Skip past dates
              if (dateStr < todayStr) return;
              // Style unavailable vs available
              if (unavailable.includes(dateStr)) {
                info.el.style.backgroundColor = 'pink';
              } else {
                info.el.style.backgroundColor = 'rgba(144,238,144,0.3)';
              }
            }
            // Append booking info if present
            if (bookings[dateStr]) {
              var div = document.createElement('div');
              div.textContent = bookings[dateStr].toLowerCase();
              div.style.fontSize = '0.7em';
              div.style.color = '#2c3e50';
              div.style.marginTop = '5px';
              info.el.appendChild(div);
            }
            // Append event info for unavailable dates
            if (eventsData[dateStr]) {
              var evDiv = document.createElement('div');
              evDiv.textContent = eventsData[dateStr];
              evDiv.style.fontSize = '0.7em';
              evDiv.style.color = '#c0392b'; // darker red
              evDiv.style.marginTop = '5px';
              info.el.appendChild(evDiv);
            }
          },
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
          },
          dateClick: function(info) {
            if (unavailable.indexOf(info.dateStr) === -1) {
              // Show booking modal for available date
              document.getElementById('bookingDate').value = info.dateStr;
              bookingModal.show();
            }
          }
        });
      }
      calendar{{ $index }}.render();
    });
  })();
  @endforeach
</script>
{{-- </main> --}}
@endsection