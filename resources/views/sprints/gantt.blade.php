@extends('layouts.dashboard')

@section('content')

<h1 class="mb-4">📊 Gantt Chart Sprint</h1>
<p>Visualisasi progres sprint berdasarkan Task & Inisiatif:</p>

<div class="card shadow-sm">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
        <span>Timeline Proyek</span>
        <div id="timeline-controls" class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-primary" data-scale="daily">Harian</button>
            <button type="button" class="btn btn-outline-primary" data-scale="weekly">Mingguan</button>
            <button type="button" class="btn btn-outline-primary active" data-scale="monthly">Bulanan</button>
        </div>
    </div>
    <div class="card-body">
        <div id="gantt_chart" style="height: 500px;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    google.charts.load("current", { packages: ["timeline"] });
    google.charts.setOnLoadCallback(initializeChart);

    let chart, dataTable;
    const container = document.getElementById('gantt_chart');

    function initializeChart() {
        chart = new google.visualization.Timeline(container);
        dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: 'string', id: 'Task' });
        dataTable.addColumn({ type: 'string', id: 'Inisiatif' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addColumn({ type: 'string', role: 'style' }); 
        dataTable.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

        const sprintData = @json($sprints);

        sprintData.forEach(s => {
           if (s.mulai && s.selesai) {
    let color = '#999';
    if (s.status === 'done') color = '#2ecc71'; // hijau
    else color = '#f1c40f'; // kuning

    let tooltip = `
        <div style="padding:5px; font-size:13px;">
            <b>Task:</b> ${s.task}<br>
            <b>Inisiatif:</b> ${s.inisiatif}<br>
            <b>Status:</b> ${s.status}<br>
            <b>Mulai:</b> ${new Date(s.mulai).toLocaleDateString()}<br>
            <b>Selesai:</b> ${new Date(s.selesai).toLocaleDateString()}
        </div>
    `;

    dataTable.addRow([
        s.task,
        s.inisiatif,
        new Date(s.mulai),
        new Date(s.selesai),
        `color: ${color}`,
        tooltip
    ]);
            }
        });

        redrawChart('monthly');

        const controls = document.getElementById('timeline-controls');
        controls.addEventListener('click', function(event) {
            if (event.target.tagName === 'BUTTON') {
                controls.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                event.target.classList.add('active');
                redrawChart(event.target.getAttribute('data-scale'));
            }
        });
    }

    function redrawChart(scale) {
        const options = {
            timeline: { colorByRowLabel: true },
            backgroundColor: '#ffffff',
            avoidOverlappingGridLines: false,
            hAxis: {},
            animation: {
                duration: 700,
                easing: 'out'
            }
        };

        if (dataTable.getNumberOfRows() === 0) {
            container.innerHTML = "<p class='text-muted'>Belum ada data sprint</p>";
            return;
        }

        const startRange = dataTable.getColumnRange(2);
        const endRange = dataTable.getColumnRange(3);
        const projectStart = new Date(startRange.min);
        const projectEnd = new Date(endRange.max);

        const ticks = [];

        if (scale === 'monthly') {
            options.hAxis.format = 'MMM yyyy';
            let d = new Date(projectStart);
            d.setDate(1);
            while (d <= projectEnd) {
                ticks.push(new Date(d));
                d.setMonth(d.getMonth() + 1);
            }
        } else if (scale === 'weekly') {
            options.hAxis.format = 'd MMM';
            let d = new Date(projectStart);
            d.setDate(d.getDate() - (d.getDay() + 6) % 7);
            while (d <= projectEnd) {
                ticks.push(new Date(d));
                d.setDate(d.getDate() + 7);
            }
        } else if (scale === 'daily') {
            options.hAxis.format = 'd MMM';
            let d = new Date(projectStart);
            while (d <= projectEnd) {
                ticks.push(new Date(d));
                d.setDate(d.getDate() + 1);
            }
        }

        if (ticks.length > 0) {
            options.hAxis.ticks = ticks;
        }

        chart.draw(dataTable, options);
    }
});
</script>
@endpush
