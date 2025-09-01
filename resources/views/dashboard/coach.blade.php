@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">Dashboard Anda</h1>

<div class="row">
    <!-- Panel Dashboard Pribadi -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Dashboard Pribadi
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card text-white bg-info shadow-sm">
                            <div class="card-body">
                                <h6>Total Mentee</h6>
                                <h3>3</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card text-white bg-warning shadow-sm">
                            <div class="card-body">
                                <h6>Task Aktif</h6>
                                <h3>5</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card text-white bg-success shadow-sm">
                            <div class="card-body">
                                <h6>Task Selesai</h6>
                                <h3>12</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card text-white bg-danger shadow-sm">
                            <div class="card-body">
                                <h6>Sprint Aktif</h6>
                                <h3>1</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Monitoring Mentee Modern & Responsive -->
    <div class="col-12">
        <h4 class="mb-3">Monitoring Mentee</h4>
        <div class="row flex-row flex-nowrap overflow-auto">
            @php
                $mentees = [
                    ['name'=>'Andi','color'=>'primary','progress'=>80,'tasks'=>['Selesai'=>5,'Berjalan'=>2,'Overdue'=>1],'activities'=>['Menyelesaikan Task 2','Memulai Sprint baru']],
                    ['name'=>'Budi','color'=>'success','progress'=>65,'tasks'=>['Selesai'=>4,'Berjalan'=>3,'Overdue'=>0],'activities'=>['Mengerjakan Task 3']],
                    ['name'=>'Siti','color'=>'warning','progress'=>45,'tasks'=>['Selesai'=>2,'Berjalan'=>2,'Overdue'=>1],'activities'=>['Terlambat mengumpulkan Task 3']],
                    ['name'=>'Yasmin','color'=>'danger','progress'=>90,'tasks'=>['Selesai'=>6,'Berjalan'=>1,'Overdue'=>0],'activities'=>['Menyelesaikan Sprint 1']]
                ];
            @endphp

            @foreach($mentees as $index => $mentee)
            <div class="col-12 col-md-6 col-lg-4 mb-4 flex-shrink-0">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-header bg-{{ $mentee['color'] }} text-white">
                        {{ $mentee['name'] }}
                    </div>
                    <div class="card-body">
                        <!-- Card Statistics -->
                        <div class="row text-center mb-3">
                            <div class="col-6 mb-2">
                                <div class="card text-white bg-info shadow-sm">
                                    <div class="card-body p-2">
                                        <small>Progress</small>
                                        <h5>{{ $mentee['progress'] }}%</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="card text-white bg-success shadow-sm">
                                    <div class="card-body p-2">
                                        <small>Task Selesai</small>
                                        <h5>{{ $mentee['tasks']['Selesai'] }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="card text-white bg-warning shadow-sm">
                                    <div class="card-body p-2">
                                        <small>Task Aktif</small>
                                        <h5>{{ $mentee['tasks']['Berjalan'] }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="card text-white bg-danger shadow-sm">
                                    <div class="card-body p-2">
                                        <small>Overdue</small>
                                        <h5>{{ $mentee['tasks']['Overdue'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart Bar per mentee -->
                        <canvas id="taskChart{{ $index }}" height="100"></canvas>

                        <!-- Aktivitas Terbaru -->
                        <h6 class="mt-3">Aktivitas Terbaru:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($mentee['activities'] as $activity)
                                <span class="badge bg-{{ $mentee['color'] }}">{{ $activity }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@foreach($mentees as $index => $mentee)
new Chart(document.getElementById('taskChart{{ $index }}'), {
    type: 'bar',
    data: {
        labels: Object.keys(@json($mentee['tasks'])),
        datasets: [{
            label: '{{ $mentee['name'] }}',
            data: Object.values(@json($mentee['tasks'])),
            backgroundColor: ['#198754', '#0d6efd', '#ffc107', '#dc3545']
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, stepSize: 1 } }
    }
});
@endforeach
</script>
@endpush

@push('styles')
<style>
    h1 { font-weight: 600; }
    .card { border-radius: 12px; }
    .card-header { font-weight: 600; }
    .progress { border-radius: 10px; }
    .overflow-auto { -webkit-overflow-scrolling: touch; }
</style>
@endpush
