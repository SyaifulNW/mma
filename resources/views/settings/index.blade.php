@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Settings - Master Data</h1>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <i class="fa fa-cogs"></i> Pengaturan Materi & Task
        </div>
        <div class="card-body">

            <!-- Input Materi -->
            <form>
                <div class="mb-3">
                    <label for="materi" class="form-label">Nama Materi</label>
                    <input type="text" class="form-control" id="materi" placeholder="Contoh: Membangun Bidang HRD">
                </div>

                <!-- Tahapan -->
                <div class="mb-3">
                    <label for="tahapan" class="form-label">Tahapan</label>
                    <input type="text" class="form-control" id="tahapan" placeholder="Contoh: Tahap 1 - Mindset & Filosofi Pengelolaan SDM">
                </div>

                <!-- Task -->
                <div class="mb-3">
                    <label for="task" class="form-label">Task</label>
                    <input type="text" class="form-control" id="task" placeholder="Contoh: Workshop People as Assets">
                </div>

                <!-- Dokumen -->
                <div class="mb-3">
                    <label for="dokumen" class="form-label">Dokumen</label>
                    <input type="text" class="form-control" id="dokumen" placeholder="Contoh: Workshop Material & Attendance List">
                </div>

                <!-- Inisiatif -->
                <div class="mb-3">
                    <label for="inisiatif" class="form-label">Inisiatif</label>
                    <textarea class="form-control" id="inisiatif" rows="3"
                              placeholder="Contoh: Adakan workshop internal tentang people as assets"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="fa fa-undo"></i> Reset
                </button>
            </form>
        </div>
    </div>

    <!-- Data Dummy (Preview) -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <i class="fa fa-database"></i> Data Materi & Task
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Materi</th>
                        <th>Tahapan</th>
                        <th>Task</th>
                        <th>Dokumen</th>
                        <th>Inisiatif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Membangun Bidang HRD</td>
                        <td>Tahap 1 - Mindset & Filosofi</td>
                        <td>Workshop People as Assets</td>
                        <td>Workshop Material</td>
                        <td>Adakan workshop internal tentang people as assets</td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Membangun Bidang Legal</td>
                        <td>Tahap 2 - Sistem Penilaian Kinerja</td>
                        <td>Implementasi KPI</td>
                        <td>Laporan KPI</td>
                        <td>Identifikasi KPI tiap divisi</td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .table th, .table td { vertical-align: middle; }
        .table th { text-align: center; }
    </style>
@endpush
