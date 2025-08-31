@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Dashboard </h1>

    <div class="row">
        <!-- Card Statistik -->
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-users fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Total Mentee</h6>
                        <h3>8</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-clipboard-list fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Task Aktif</h6>
                        <h3>15</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Task Selesai</h6>
                        <h3>48</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-rocket fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Sprint Aktif</h6>
                        <h3>2</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Progress per Mentee</div>
                <div class="card-body">
                    <canvas id="menteeProgressChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Distribusi Task</div>
                <div class="card-body">
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="card shadow-sm mt-4">
        <div class="card-header">Aktivitas Terbaru Mentee</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><i class="fa fa-check-circle text-success me-2"></i> Andi menyelesaikan Task 2</li>
                <li class="list-group-item"><i class="fa fa-exclamation-circle text-danger me-2"></i> Siti terlambat mengumpulkan Task 3</li>
                <li class="list-group-item"><i class="fa fa-rocket text-primary me-2"></i> Budi memulai Sprint baru</li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Chart Progress per Mentee
  new Chart(document.getElementById('menteeProgressChart'), {
    type: 'bar',
    data: {
      labels: ['Andi', 'Budi', 'Siti', 'Yasmin'],
      datasets: [{
        label: 'Progress %',
        data: [80, 60, 45, 90],
        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, max: 100 } }
    }
  });

  // Chart Distribusi Task
  new Chart(document.getElementById('taskChart'), {
    type: 'doughnut',
    data: {
      labels: ['Selesai', 'Berjalan', 'Overdue'],
      datasets: [{
        data: [48, 15, 5],
        backgroundColor: ['#198754', '#0d6efd', '#dc3545']
      }]
    }
  });
</script>
@endpush

@push('styles')
<style>
    h1 { font-weight: 600; }
    .card { border-radius: 12px; }
    .card-header { font-weight: 600; }
</style>
@endpush
