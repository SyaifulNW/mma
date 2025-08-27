@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Dashboard Coach</h1>

    <div class="row">
        <!-- Card Jumlah Mentee -->
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-users fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Total Mentee</h6>
                        <h3>15</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Task Progress -->
        <div class="col-md-4">
            <div class="card text-white bg-success shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title">Task Selesai</h6>
                        <h3>120</h3>
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
                        <h3>30</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Progres Mentee</div>
                <div class="card-body">
                    <canvas id="menteeProgressChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Distribusi Task Mentee</div>
                <div class="card-body">
                    <canvas id="taskDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Progres Mentee
  new Chart(document.getElementById('menteeProgressChart'), {
    type: 'bar',
    data: {
      labels: ['Mentee 1', 'Mentee 2', 'Mentee 3'],
      datasets: [{
        label: 'Progress %',
        data: [80, 60, 90],
        backgroundColor: ['#0d6efd', '#198754', '#ffc107']
      }]
    },
    options: { scales: { y: { beginAtZero: true, max: 100 } } }
  });

  // Distribusi Task
  new Chart(document.getElementById('taskDistributionChart'), {
    type: 'doughnut',
    data: {
      labels: ['Selesai', 'Dalam Proses', 'Belum Mulai'],
      datasets: [{
        data: [120, 45, 30],
        backgroundColor: ['#20c997', '#ffc107', '#dc3545']
      }]
    }
  });
</script>
@endpush
