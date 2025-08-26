@extends('layouts.app')

@section('content')
<h1 class="mb-4">Sprint Management (Monitoring Peserta)</h1>

<div class="mb-3">
    <button class="btn btn-success btn-sm"><i class="fa fa-file-excel"></i> Export Excel</button>
    <button class="btn btn-secondary btn-sm"><i class="fa fa-print"></i> Cetak</button>
    <button class="btn btn-info btn-sm"><i class="fa fa-sync"></i> Refresh</button>
    <button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah Sprint</button>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table id="sprintTable" class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>Task/Inisiatif</th>
                    <th>Indikator</th>
                    <th>Pencapaian</th>
                    <th>Status</th>
                    <th>Timeline</th>
                </tr>
            </thead>
            <tbody>
                {{-- Data dummy sementara --}}
                <tr>
                    <td>1</td>
                    <td><strong>Yasmin</strong></td>
                    <td>Adakan workshop internal tentang people as assets</td>
                    <td>Agenda berjalan lancar</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: 95%">95%</div>
                        </div>
                    </td>
                    <td><span class="badge bg-success">Open</span></td>
                    <td>01 Jul 2025 - 31 Jul 2025</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><strong>Linda</strong></td>
                    <td>Buat data kontribusi karyawan pada revenue</td>
                    <td>Data sesuai target</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-danger" style="width: 15%">15%</div>
                        </div>
                    </td>
                    <td><span class="badge bg-danger">Open</span></td>
                    <td>05 Jul 2025 - 30 Jul 2025</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td><strong>Tursia</strong></td>
                    <td>Publikasikan kisah sukses karyawan berprestasi</td>
                    <td>Kisah sukses terpublikasi</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-warning text-dark" style="width: 40%">40%</div>
                        </div>
                    </td>
                    <td><span class="badge bg-warning text-dark">Open</span></td>
                    <td>10 Jul 2025 - 20 Jul 2025</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#sprintTable').DataTable({
        pageLength: 5,
        order: [[0, 'asc']],
        language: {
            search: "Cari Peserta / Task:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f1f8ff !important;
    }
    .progress-bar {
        font-weight: bold;
    }
</style>
@endpush
