@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Daftar Peserta (Mentee)</h1>

    <div class="mb-3">
        <button class="btn btn-success btn-sm"><i class="fa fa-file-excel"></i> Export Excel</button>
        <button class="btn btn-secondary btn-sm"><i class="fa fa-print"></i> Cetak</button>
        <button class="btn btn-info btn-sm"><i class="fa fa-sync"></i> Refresh</button>
        <button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah Mentee</button>
    </div>

    <table id="pesertaTable" class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>Coach</th>
                <th>Status</th>
                <th>Timeline Sprint</th>
            </tr>
        </thead>
        <tbody>
            {{-- Dummy Data --}}
            <tr>
                <td>1</td>
                <td><strong>Yasmin</strong></td>
                <td>yasmin@example.com</td>
                <td>Coach Ahmad</td>
                <td><span class="badge bg-success">Aktif</span></td>
                <td>01 Jul 2025 - 31 Jul 2025</td>
            </tr>
            <tr>
                <td>2</td>
                <td><strong>Linda</strong></td>
                <td>linda@example.com</td>
                <td>Coach Budi</td>
                <td><span class="badge bg-warning">On Progress</span></td>
                <td>05 Jul 2025 - 30 Jul 2025</td>
            </tr>
            <tr>
                <td>3</td>
                <td><strong>Tursia</strong></td>
                <td>tursia@example.com</td>
                <td>Coach Sinta</td>
                <td><span class="badge bg-danger">Tidak Aktif</span></td>
                <td>-</td>
            </tr>
        </tbody>
    </table>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#pesertaTable').DataTable({
        pageLength: 5,
        order: [[0, 'asc']]
    });
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .badge { font-size: 0.9rem; }
</style>
@endpush
