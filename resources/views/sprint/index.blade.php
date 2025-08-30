@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">📊 Sprint Timeline <small class="text-muted">(Triwulan & Minggu)</small></h1>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div class="d-flex gap-2">
        <select id="triwulanFilter" class="form-select form-select-sm">
            <option value="Q1">Triwulan 1</option>
            <option value="Q2">Triwulan 2</option>
            <option value="Q3">Triwulan 3</option>
            <option value="Q4">Triwulan 4</option>
        </select>
        <select id="viewFilter" class="form-select form-select-sm">
            <option value="minggu">Per Minggu</option>
            <option value="hari">Per Hari</option>
        </select>
    </div>
    <button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah Sprint</button>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-calendar"></i> Timeline Sprint Peserta
    </div>
    <div class="card-body">
        {{-- Timeline Grid --}}
        <div id="timelineView" class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Peserta</th>
                        {{-- Dinamis: Minggu atau Hari --}}
                        <th>Minggu 1</th>
                        <th>Minggu 2</th>
                        <th>Minggu 3</th>
                        <th>Minggu 4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Yasmin</strong></td>
                        <td class="bg-success text-white">95%</td>
                        <td class="bg-secondary">-</td>
                        <td class="bg-secondary">-</td>
                        <td class="bg-secondary">-</td>
                    </tr>
                    <tr>
                        <td><strong>Raka</strong></td>
                        <td class="bg-info text-white">60%</td>
                        <td class="bg-warning text-dark">Progress</td>
                        <td class="bg-secondary">-</td>
                        <td class="bg-secondary">-</td>
                    </tr>
                    <tr>
                        <td><strong>Lina</strong></td>
                        <td class="bg-danger text-white">Overdue</td>
                        <td class="bg-secondary">-</td>
                        <td class="bg-secondary">-</td>
                        <td class="bg-secondary">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    // Filter view per minggu/hari
    $('#viewFilter').on('change', function(){
        let view = $(this).val();
        let thead = $('#timelineView thead tr');
        thead.find('th:not(:first)').remove(); // reset
        if(view === 'minggu'){
            thead.append('<th>Minggu 1</th><th>Minggu 2</th><th>Minggu 3</th><th>Minggu 4</th>');
        } else {
            thead.append('<th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th><th>Min</th>');
        }
    });
});
</script>
@endpush
