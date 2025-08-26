@extends('layouts.app')

@section('content')
<h1 class="mb-4">Sprint Management</h1>

<div class="mb-3">
    <button class="btn btn-success btn-sm">Export Excel</button>
    <button class="btn btn-secondary btn-sm">Cetak</button>
    <button class="btn btn-info btn-sm">Refresh</button>
    <button class="btn btn-warning btn-sm">Tambah</button>
</div>

<table id="sprintTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Task/Inisiatif</th>
            <th>Kendala</th>
            <th>Identifikasi</th>
            <th>Solusi</th>
            <th>Indikator</th>
            <th>Pencapaian</th>
            <th>Kategori</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr class="table-success">
            <td>1</td>
            <td>Agenda harian Rinda Juli 2025</td>
            <td>Agenda harian Rinda Juli 2025</td>
            <td>Agenda harian Rinda Juli 2025</td>
            <td>Agenda harian Rinda Juli 2025</td>
            <td>Agenda harian Rinda Juli 2025</td>
            <td><span class="badge bg-success">95%</span></td>
            <td>Rutin</td>
            <td>Open</td>
        </tr>
        <tr class="table-danger">
            <td>2</td>
            <td>Training Yoseph Mario Mali Ngara</td>
            <td>Training Harian</td>
            <td>Training Harian</td>
            <td>Training Harian</td>
            <td>Training berjalan sesuai jadwal</td>
            <td><span class="badge bg-danger">15%</span></td>
            <td>Rutin</td>
            <td>Open</td>
        </tr>
        <tr class="table-danger">
            <td>3</td>
            <td>Pembuatan alur kerja Teknisi CCTV</td>
            <td>Belum ada alur kerja</td>
            <td>SOP belum disusun</td>
            <td>Membuat SOP</td>
            <td>SOP jadi panduan</td>
            <td><span class="badge bg-danger">0%</span></td>
            <td>Berkala</td>
            <td>Open</td>
        </tr>
        <tr class="table-warning">
            <td>4</td>
            <td>Refill penggunaan kertas bekas</td>
            <td>Penggunaan kertas bekas</td>
            <td>Ada SOP</td>
            <td>Membuat SOP seleksi</td>
            <td>SOP dilaksanakan</td>
            <td><span class="badge bg-warning">40%</span></td>
            <td>Berkala</td>
            <td>Open</td>
        </tr>
    </tbody>
</table>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#sprintTable').DataTable();
});
</script>
@endpush
