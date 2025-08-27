@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <!-- Card Statistik -->
        <div class="col-md-3">
            <div class="card text-white bg-success shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-user-tie fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Coach Aktif</h6>
                        <h3>12</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-users fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Peserta</h6>
                        <h3>45</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-clipboard-list fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Sprint Aktif</h6>
                        <h3>3</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Task Selesai</h6>
                        <h3>120</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Progress Sprint</div>
                <div class="card-body">
                    <canvas id="sprintChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Distribusi Peserta per Coach</div>
                <div class="card-body">
                    <canvas id="coachChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="card shadow-sm mt-4">
        <div class="card-header">Aktivitas Terbaru</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><i class="fa fa-check-circle text-success me-2"></i> Yasmin menyelesaikan Task 1</li>
                <li class="list-group-item"><i class="fa fa-tasks text-primary me-2"></i> Linda memulai Sprint baru</li>
                <li class="list-group-item"><i class="fa fa-user-plus text-warning me-2"></i> Coach baru bergabung: Bapak Ahmad</li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Chart Progress Sprint
  new Chart(document.getElementById('sprintChart'), {
    type: 'bar',
    data: {
      labels: ['Sprint 1', 'Sprint 2', 'Sprint 3'],
      datasets: [{
        label: 'Progress %',
        data: [90, 60, 30],
        backgroundColor: ['#0d6efd', '#198754', '#ffc107']
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, max: 100 } }
    }
  });

  // Chart Distribusi Peserta per Coach
  new Chart(document.getElementById('coachChart'), {
    type: 'pie',
    data: {
      labels: ['Coach A', 'Coach B', 'Coach C'],
      datasets: [{
        data: [15, 20, 10],
        backgroundColor: ['#0d6efd', '#dc3545', '#20c997']
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
