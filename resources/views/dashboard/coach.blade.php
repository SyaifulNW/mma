@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4 fw-bold text-primary">📊 Dashboard Coach</h1>

    <div class="row">
        {{-- Progres Peserta --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white fw-semibold">
                    Progres Peserta
                </div>
                <div class="card-body">
                    <canvas id="progressPesertaChart" height="150"></canvas>
                </div>
            </div>
        </div>

        {{-- Task Berjalan --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white fw-semibold">
                    Task Berjalan
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Task A 
                            <span class="badge bg-primary rounded-pill">70% ✅</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Task B 
                            <span class="badge bg-warning rounded-pill">40%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-danger">
                            Task C 
                            <span class="badge bg-danger rounded-pill">Overdue ⚠️</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Pencapaian per Peserta --}}
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-info text-white fw-semibold">
                    Report Pencapaian per Peserta
                </div>
                <div class="card-body">
                    <canvas id="reportPesertaChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chat/Forum Diskusi --}}
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-dark text-white fw-semibold">
                    Forum Diskusi Kelompok
                </div>
                <div class="card-body" style="height:300px; overflow-y:auto; background:#f8f9fa;">
                    <div class="mb-2"><b>Ali:</b> Bagaimana progres task minggu ini?</div>
                    <div class="mb-2"><b>Budi:</b> Task 1 sudah selesai 80% coach 👍</div>
                </div>
                <div class="card-footer">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Tulis pesan...">
                            <button class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Bar Chart: Progres Peserta
    const ctx1 = document.getElementById('progressPesertaChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Mentee A', 'Mentee B', 'Mentee C'],
            datasets: [{
                label: 'Progress (%)',
                data: [70, 40, 85],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#333',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true, 
                    max: 100,
                    ticks: { stepSize: 20 }
                } 
            }
        }
    });

    // Line Chart: Report Pencapaian per Peserta
    const ctx2 = document.getElementById('reportPesertaChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April'],
            datasets: [
                {
                    label: 'Mentee A',
                    data: [20, 45, 60, 80],
                    borderColor: '#4e73df',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(78,115,223,0.1)'
                },
                {
                    label: 'Mentee B',
                    data: [10, 30, 50, 65],
                    borderColor: '#1cc88a',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(28,200,138,0.1)'
                },
                {
                    label: 'Mentee C',
                    data: [25, 55, 70, 90],
                    borderColor: '#36b9cc',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(54,185,204,0.1)'
                }
            ]
        },
        options: { 
            responsive: true,
            plugins: {
                tooltip: { mode: 'index', intersect: false },
                legend: { position: 'bottom' }
            }
        }
    });
</script>

@endsection


