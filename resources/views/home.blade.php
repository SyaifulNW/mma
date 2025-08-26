@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Lead Aktif</h5>
                    <p class="card-text display-6">{{ $leadCount ?? 150 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Coach Aktif</h5>
                    <p class="card-text display-6">12</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Peserta</h5>
                    <p class="card-text display-6">45</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Sprint Aktif</h5>
                    <p class="card-text display-6">3</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card mt-4">
        <div class="card-header">Progress Sprint</div>
        <div class="card-body">
            <canvas id="sprintChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('sprintChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Sprint 1', 'Sprint 2', 'Sprint 3'],
      datasets: [{
        label: 'Progress %',
        data: [90, 60, 30],
        backgroundColor: ['#0d6efd', '#198754', '#ffc107']
      }]
    }
  });
</script>
@endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>