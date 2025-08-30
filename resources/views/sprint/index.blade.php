@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">📊 Sprint Management <small class="text-muted">(Monitoring Peserta)</small></h1>

<div class="mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
    <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-success btn-sm"><i class="fa fa-file-excel"></i> Export Excel</button>
        <button class="btn btn-secondary btn-sm"><i class="fa fa-print"></i> Cetak</button>
        <button class="btn btn-info btn-sm"><i class="fa fa-sync"></i> Refresh</button>
    </div>
    <div>
        <button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah Sprint</button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-users"></i> Daftar Sprint Peserta (Mentee)
    </div>
    <div class="card-body table-responsive">
        <table id="sprintTable" class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>Task / Inisiatif</th>
                    <th>Pencapaian</th>
                    <th>Status</th>
                    <th>Timeline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Dummy Data --}}
                <tr>
                    <td>1</td>
                    <td><strong>Yasmin</strong></td>
                    <td>Adakan workshop internal tentang people as assets</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: 95%">95%</div>
                        </div>
                    </td>
                    <td><span class="badge bg-success">Selesai</span></td>
                    <td>01 Jul 2025 - 31 Jul 2025</td>
                    <td class="text-center d-flex flex-wrap justify-content-center gap-1">
                        <button class="btn btn-sm btn-outline-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailSprintModal"
                                data-peserta="Yasmin"
                                data-task="Adakan workshop internal tentang people as assets"
                                data-status="Selesai"
                                data-progress="95%"
                                data-timeline="01 Jul 2025 - 31 Jul 2025">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-comment"></i></button>
                        <button class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i></button>
                    </td>
                </tr>
                {{-- Tambahkan data lain sama seperti di atas --}}
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Detail Sprint --}}
<div class="modal fade" id="detailSprintModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-info-circle"></i> Detail Sprint Peserta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered">
          <tr>
            <th>Peserta</th>
            <td id="detailPeserta"></td>
          </tr>
          <tr>
            <th>Task / Inisiatif</th>
            <td id="detailTask"></td>
          </tr>
          <tr>
            <th>Status</th>
            <td id="detailStatus"></td>
          </tr>
          <tr>
            <th>Pencapaian</th>
            <td id="detailProgress"></td>
          </tr>
          <tr>
            <th>Timeline</th>
            <td id="detailTimeline"></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
      </div>
    </div>
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
        responsive: true,
        language: {
            search: "🔎 Cari Peserta / Task:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "⬅️", next: "➡️" }
        }
    });

    // Event show detail modal
    $('#detailSprintModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#detailPeserta').text(button.data('peserta'));
        $('#detailTask').text(button.data('task'));
        $('#detailStatus').text(button.data('status'));
        $('#detailProgress').text(button.data('progress'));
        $('#detailTimeline').text(button.data('timeline'));
    });
});
</script>
@endpush
