@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Daftar Coach</h1>

    <div class="mb-3">
        <button class="btn btn-success btn-sm"><i class="fa fa-file-excel"></i> Export Excel</button>
        <button class="btn btn-secondary btn-sm"><i class="fa fa-print"></i> Cetak</button>
        <button class="btn btn-info btn-sm"><i class="fa fa-sync"></i> Refresh</button>
        <button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah Coach</button>
    </div>

    <table id="coachTable" class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Coach</th>
                <th>Email</th>
                <th>Spesialisasi</th>
                <th>Jumlah Peserta</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- Dummy Data --}}
            <tr>
                <td>1</td>
                <td><strong>Coach Fitra</strong></td>
                <td>Fitra@example.com</td>
                <td>HRD & Leadership</td>
                <td><span class="badge bg-primary">12</span></td>
                <td><span class="badge bg-success">Aktif</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td><strong>Coach Farid</strong></td>
                <td>Farid@example.com</td>
                <td>Branding & Marketing</td>
                <td><span class="badge bg-primary">8</span></td>
                <td><span class="badge bg-warning">Cuti</span></td>
            </tr>
            <tr>
                <td>3</td>
                <td><strong>Coach Fahmi</strong></td>
                <td>fahmi@example.com</td>
                <td>Legal & Finance</td>
                <td><span class="badge bg-primary">15</span></td>
                <td><span class="badge bg-danger">Non Aktif</span></td>
            </tr>
        </tbody>
    </table>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#coachTable').DataTable({
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
