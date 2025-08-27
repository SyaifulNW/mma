@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Sprint Saya</h1>
    <p>Halo, {{ Auth::user()->name }} 👋. Berikut progres sprint kamu saat ini:</p>

    <!-- Table Sprint -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="mySprintTable" class="table table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Sprint</th>
                        <th>Task/Inisiatif</th>
                        <th>Indikator</th>
                        <th>Pencapaian</th>
                        <th>Status</th>
                        <th>Timeline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dummy data --}}
                    <tr>
                        <td>1</td>
                        <td><strong>Sprint 1</strong></td>
                        <td>Membuat laporan mingguan</td>
                        <td>Laporan selesai sesuai standar</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" style="width: 90%">90%</div>
                            </div>
                        </td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td>01 - 15 Juli 2025</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><strong>Sprint 2</strong></td>
                        <td>Presentasi ide bisnis</td>
                        <td>Presentasi mendapat feedback coach</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-warning text-dark" style="width: 40%">40%</div>
                            </div>
                        </td>
                        <td><span class="badge bg-warning text-dark">Berjalan</span></td>
                        <td>20 Juli - 05 Agustus 2025</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart progress -->
    <div class="card shadow-sm mt-4">
        <div class="card-header">Progres Sprint Saya</div>
        <div class="card-body">
            <canvas id="mySprintChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart progress sprint peserta
    new Chart(document.getElementById('mySprintChart'), {
        type: 'line',
        data: {
            labels: ['Sprint 1', 'Sprint 2'],
            datasets: [{
                label: 'Progress %',
                data: [90, 40],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: { scales: { y: { beginAtZero: true, max: 100 } } }
    });
</script>
@endpush

@push('styles')
<style>
    .table-hover tbody tr:hover { background-color: #f1f8ff !important; }
    .progress-bar { font-weight: bold; }
</style>
@endpush
