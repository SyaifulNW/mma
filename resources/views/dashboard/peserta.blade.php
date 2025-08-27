@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Dashboard Peserta</h1>
    <p>Halo, {{ Auth::user()->name }} 👋. Berikut progres kamu:</p>

    <div class="row">
        <!-- Card Sprint Aktif -->
        <div class="col-md-4">
            <div class="card text-white bg-info shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-clipboard-list fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Sprint Aktif</h6>
                        <h3>2</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Task Selesai -->
        <div class="col-md-4">
            <div class="card text-white bg-success shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Task Selesai</h6>
                        <h3>25</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Task Pending -->
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-hourglass-half fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Task Belum Selesai</h6>
                        <h3>10</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Progres -->
    <div class="card shadow-sm mt-4">
        <div class="card-header">Progres Sprint Kamu</div>
        <div class="card-body">
            <canvas id="sprintProgressChart"></canvas>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="card shadow-sm mt-4">
        <div class="card-header">Aktivitas Terbaru</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><i class="fa fa-check-circle text-success me-2"></i> Menyelesaikan Task: Buat Landing Page</li>
                <li class="list-group-item"><i class="fa fa-play text-primary me-2"></i> Memulai Sprint 2</li>
                <li class="list-group-item"><i class="fa fa-upload text-warning me-2"></i> Upload Dokumen Pitch Deck</li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Progres Sprint Peserta
  new Chart(document.getElementById('sprintProgressChart'), {
    type: 'line',
    data: {
      labels: ['Sprint 1', 'Sprint 2'],
      datasets: [{
        label: 'Progress %',
        data: [100, 40],
        borderColor: '#0d6efd',
        backgroundColor: 'rgba(13,110,253,0.3)',
        fill: true,
        tension: 0.3
      }]
    },
    options: { scales: { y: { beginAtZero: true, max: 100 } } }
  });
</script>
@endpush
