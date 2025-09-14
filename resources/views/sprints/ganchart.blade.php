@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Sprint Saya</h1>
    <p>Berikut progres sprint kamu saat ini:</p>

    <div class="card shadow-sm mb-4">
        {{-- Konten tabel sprint tetap sama --}}
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
                        <td>2025-07-01 → 2025-07-15</td>
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
                        <td>2025-07-20 → 2025-08-05</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
            <span>📊 Timeline Proyek (Gantt Chart)</span>
            <div id="timeline-controls" class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-primary" data-scale="daily">Harian</button>
                <button type="button" class="btn btn-outline-primary" data-scale="weekly">Mingguan</button>
                <button type="button" class="btn btn-outline-primary active" data-scale="quarterly">3 Bulan</button>
            </div>
        </div>
        <div class="card-body">
            <div id="gantt_chart" style="height: 350px;"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    google.charts.load("current", { packages: ["timeline"] });
    google.charts.setOnLoadCallback(initializeChart);

    // Definisikan variabel chart dan dataTable di luar fungsi agar bisa diakses di mana saja
    let chart;
    let dataTable;
    const container = document.getElementById('gantt_chart');

    function initializeChart() {
        chart = new google.visualization.Timeline(container);
        dataTable = new google.visualization.DataTable();

        // Mendefinisikan kolom untuk Gantt Chart
        dataTable.addColumn({ type: 'string', id: 'Task Name' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });

        // Menambahkan data baris
        dataTable.addRows([
            ['Planning',       new Date(2019, 0, 15), new Date(2019, 2, 31)],
            ['Research',       new Date(2019, 1, 1),  new Date(2019, 2, 20)],
            ['Design',         new Date(2019, 2, 15), new Date(2019, 3, 30)],
            ['Implementation', new Date(2019, 3, 1),  new Date(2019, 6, 20)],
            ['Follow up',      new Date(2019, 6, 1),  new Date(2019, 6, 31)]
        ]);
        
        // Gambar chart pertama kali dengan skala default 'quarterly' (3 Bulan)
        redrawChart('quarterly');

        // [BARU] Tambahkan event listener untuk tombol kontrol
        const controls = document.getElementById('timeline-controls');
        controls.addEventListener('click', function(event) {
            if (event.target.tagName === 'BUTTON') {
                // Hapus kelas 'active' dari semua tombol
                controls.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                // Tambahkan kelas 'active' ke tombol yang diklik
                event.target.classList.add('active');
                
                const scale = event.target.getAttribute('data-scale');
                redrawChart(scale);
            }
        });
    }

    // [BARU] Fungsi untuk menggambar ulang chart dengan skala yang berbeda
    function redrawChart(scale) {
        const options = {
            timeline: { colorByRowLabel: true },
            backgroundColor: '#ffffff',
            avoidOverlappingGridLines: false,
            hAxis: {} // Siapkan objek hAxis untuk diisi
        };

        // Dapatkan rentang tanggal dari seluruh data
        const startRange = dataTable.getColumnRange(1);
        const endRange = dataTable.getColumnRange(2);
        const projectStart = new Date(startRange.min);
        const projectEnd = new Date(endRange.max);

        const ticks = [];
        
        if (scale === 'quarterly') {
            options.hAxis.format = 'MMM yyyy';
            let d = new Date(projectStart);
            d.setDate(1); // Mulai dari tanggal 1 setiap bulan
            while (d <= projectEnd) {
                if (d.getMonth() % 3 === 0) { // Tambahkan tanda setiap 3 bulan (Jan, Apr, Jul, Okt)
                    ticks.push(new Date(d));
                }
                d.setMonth(d.getMonth() + 1);
            }
        } else if (scale === 'weekly') {
            options.hAxis.format = 'd MMM';
            let d = new Date(projectStart);
            // Mundur ke hari Senin terdekat
            d.setDate(d.getDate() - (d.getDay() + 6) % 7);
            while (d <= projectEnd) {
                ticks.push(new Date(d));
                d.setDate(d.getDate() + 7); // Tambahkan tanda setiap 7 hari
            }
        } else if (scale === 'daily') {
            options.hAxis.format = 'EEE, d'; // Format: Hari, Tanggal (mis: Sen, 5)
            let d = new Date(projectStart);
            while (d <= projectEnd) {
                ticks.push(new Date(d));
                d.setDate(d.getDate() + 5); // Tambahkan tanda setiap 5 hari agar tidak terlalu padat
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

@push('styles')
<style>
    .table-hover tbody tr:hover { background-color: #f1f8ff !important; }
    .progress-bar { font-weight: bold; }
</style>
@endpush