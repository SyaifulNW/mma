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
            <div class="card-body text-center">
                <div id="dashboard-stats" class="row justify-content-center"></div>

                <h6 class="mt-4">Presentase Task Selesai:</h6>
                <div class="progress mb-2">
                    <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%">
                        0%
                    </div>
                </div>

                <div id="overdue-alert"></div>
            </div>
        </div>
    </div>

    <!-- Panel Monitoring Mentee -->
    <div class="col-12">
        <h4 class="mb-3">Monitoring Mentee</h4>
        <div id="mentee-dashboard" class="row flex-row flex-nowrap overflow-auto"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){

    // ==== Data Dashboard Pribadi ====
    const personalTasks = {
        totalMentee: 2,
        aktif: 4,
        selesai: 8,
        overdue: 1
    };

    // ==== Data Mentee ====
    const mentees = [
        {
            name: 'Yasmin',
            progress: 70,
            tasks: { Selesai: 5, Berjalan: 2, Overdue: 1 },
            activities: ['Selesai Task 3', 'Sedang Task 4']
        },
        {
            name: 'Linda',
            progress: 40,
            tasks: { Selesai: 3, Berjalan: 4, Overdue: 0 },
            activities: ['Sedang Task 2']
        }
    ];

    // ==== Dashboard Pribadi ====
    const dashboardStats = document.getElementById('dashboard-stats');
    const statsHTML = `
        <div class="col-6 col-md-4 mb-3">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h6>Total Mentee</h6>
                    <h3>${personalTasks.totalMentee}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 mb-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h6>Task Aktif</h6>
                    <h3>${personalTasks.aktif}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 mb-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h6>Task Selesai</h6>
                    <h3>${personalTasks.selesai}</h3>
                </div>
            </div>
        </div>
    `;
    dashboardStats.innerHTML = statsHTML;

    // Progress bar
    const totalTask = personalTasks.aktif + personalTasks.selesai + personalTasks.overdue;
    const progressPercent = totalTask > 0 ? Math.round(personalTasks.selesai / totalTask * 100) : 0;
    const progressBar = document.getElementById('progress-bar');
    progressBar.style.width = progressPercent + '%';
    progressBar.textContent = progressPercent + '%';

    // Alert overdue
    const overdueAlert = document.getElementById('overdue-alert');
    if(personalTasks.overdue > 0){
        overdueAlert.innerHTML = `<div class="alert alert-danger p-2">⚠️ ${personalTasks.overdue} Task Anda sudah jatuh tempo!</div>`;
    }

    // ==== Monitoring Mentee ====
    const menteeDashboard = document.getElementById('mentee-dashboard');
    menteeDashboard.innerHTML = "";
    mentees.forEach(mentee => {
        menteeDashboard.innerHTML += `
        <div class="col-12 col-md-6 col-lg-4 mb-4 flex-shrink-0">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span>${mentee.name}</span>
                    <span>${mentee.progress}%</span>
                </div>
                <div class="card-body">
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" role="progressbar" style="width:${mentee.progress}%">
                            ${mentee.progress}%
                        </div>
                    </div>
                    <div class="row text-center mb-3">
                        <div class="col-4 mb-2">
                            <div class="card text-white bg-success shadow-sm">
                                <div class="card-body p-2">
                                    <small>Selesai</small>
                                    <h5>${mentee.tasks.Selesai}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="card text-white bg-warning shadow-sm">
                                <div class="card-body p-2">
                                    <small>Aktif</small>
                                    <h5>${mentee.tasks.Berjalan}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="card text-white bg-danger shadow-sm">
                                <div class="card-body p-2">
                                    <small>Overdue</small>
                                    <h5>${mentee.tasks.Overdue}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    ${mentee.tasks.Overdue > 0 ? `<div class="alert alert-danger p-2">⚠️ ${mentee.tasks.Overdue} task jatuh tempo!</div>` : ''}
                    <h6 class="mt-3">Aktivitas Terbaru:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        ${mentee.activities.map(act => `<span class="badge bg-primary">${act}</span>`).join('')}
                    </div>
                </div>
            </div>
        </div>
        `;
    });
});
</script>
@endpush
