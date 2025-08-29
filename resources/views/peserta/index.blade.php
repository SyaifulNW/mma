@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Daftar Peserta (Mentee)</h1>

    <div class="mb-3">
        <button class="btn btn-success btn-sm"><i class="fa fa-file-excel"></i> Export Excel</button>
        <button class="btn btn-secondary btn-sm"><i class="fa fa-print"></i> Cetak</button>
        <button class="btn btn-info btn-sm"><i class="fa fa-sync"></i> Refresh</button>
        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#menteeModal">
            <i class="fa fa-plus"></i> Tambah Mentee
        </button>
    </div>

    <table id="pesertaTable" class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Level</th>
                <th>No WA</th>
                <th>Kota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Dummy Data --}}
            <tr>
                <td>1</td>
                <td><strong>Yasmin</strong></td>
                <td><span class="badge bg-secondary">Start Up 🚀</span></td>
                <td>081234567890</td>
                <td>Jakarta</td>
                <td>
                    <button class="btn btn-sm btn-info btn-view" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailMenteeModal"
                            data-nama="Yasmin"
                            data-level="Start Up 🚀"
                            data-wa="081234567890"
                            data-kota="Jakarta">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-primary btn-edit"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td><strong>Linda</strong></td>
                <td><span class="badge bg-primary">Stand Up 💪</span></td>
                <td>082233445566</td>
                <td>Bandung</td>
                <td>
                    <button class="btn btn-sm btn-info btn-view" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailMenteeModal"
                            data-nama="Linda"
                            data-level="Stand Up 💪"
                            data-wa="082233445566"
                            data-kota="Bandung">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-primary btn-edit"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Modal Tambah/Edit Mentee -->
    <div class="modal fade" id="menteeModal" tabindex="-1" aria-labelledby="menteeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="formMentee">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="menteeModalLabel"><i class="fa fa-user-plus"></i> Tambah Mentee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    <input type="hidden" id="rowIndex">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Peserta</label>
                        <input type="text" id="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select id="level" class="form-select">
                            <option value="Start Up 🚀">Start Up 🚀</option>
                            <option value="Stand Up 💪">Stand Up 💪</option>
                            <option value="Step Up 📈">Step Up 📈</option>
                            <option value="Grow Up 🌱">Grow Up 🌱</option>
                            <option value="Scale Up 🌍">Scale Up 🌍</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wa" class="form-label">No WA</label>
                        <input type="text" id="wa" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" id="kota" class="form-control" required>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- Modal Detail Mentee -->
    <div class="modal fade" id="detailMenteeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fa fa-info-circle"></i> Detail Mentee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Peserta</th>
                            <td id="detailNama"></td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td id="detailLevel"></td>
                        </tr>
                        <tr>
                            <th>No WA</th>
                            <td id="detailWA"></td>
                        </tr>
                        <tr>
                            <th>Kota</th>
                            <td id="detailKota"></td>
                        </tr>
                        <tr>
                            <th>Keterangan Level</th>
                            <td id="detailKeterangan"></td>
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
<script>
$(document).ready(function () {
    function getLevelBadge(level) {
        switch(level){
            case 'Start Up 🚀': return '<span class="badge bg-secondary">'+level+'</span>';
            case 'Stand Up 💪': return '<span class="badge bg-primary">'+level+'</span>';
            case 'Step Up 📈': return '<span class="badge bg-info text-dark">'+level+'</span>';
            case 'Grow Up 🌱': return '<span class="badge bg-success">'+level+'</span>';
            case 'Scale Up 🌍': return '<span class="badge bg-warning text-dark">'+level+'</span>';
            default: return level;
        }
    }

    function getLevelDescription(level){
        switch(level){
            case 'Start Up 🚀': return 'Tahap mulai jalan, validasi ide.';
            case 'Stand Up 💪': return 'Bisnis mulai tegak, punya pondasi & sistem dasar.';
            case 'Step Up 📈': return 'Mulai naik level, tambah tim & pasar.';
            case 'Grow Up 🌱': return 'Tumbuh lebih besar, stabil & profesional.';
            case 'Scale Up 🌍': return 'Berkembang pesat & melipatgandakan bisnis.';
            default: return '';
        }
    }

    let table = $('#pesertaTable').DataTable({
        pageLength: 5,
        order: [[0, 'asc']]
    });

    // Tambah Mentee
    $('[data-bs-target="#menteeModal"]').on('click', function(){
        $('#menteeModalLabel').text('Tambah Mentee');
        $('#formMentee')[0].reset();
        $('#rowIndex').val('');
    });

    // Simpan Tambah/Edit
    $('#formMentee').on('submit', function(e){
        e.preventDefault();
        let nama = $('#nama').val();
        let level = $('#level').val();
        let wa = $('#wa').val();
        let kota = $('#kota').val();
        let rowIndex = $('#rowIndex').val();

        let aksiBtns = `
            <button class="btn btn-sm btn-info btn-view" 
                    data-bs-toggle="modal" 
                    data-bs-target="#detailMenteeModal"
                    data-nama="${nama}"
                    data-level="${level}"
                    data-wa="${wa}"
                    data-kota="${kota}">
                <i class="fa fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-primary btn-edit"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></button>
        `;

        if(rowIndex === ""){
            let rowCount = table.rows().count() + 1;
            table.row.add([
                rowCount,
                `<strong>${nama}</strong>`,
                getLevelBadge(level),
                wa,
                kota,
                aksiBtns
            ]).draw(false);
        } else {
            table.row(rowIndex).data([
                parseInt(rowIndex) + 1,
                `<strong>${nama}</strong>`,
                getLevelBadge(level),
                wa,
                kota,
                aksiBtns
            ]).draw(false);
        }

        $('#menteeModal').modal('hide');
    });

    // Edit
    $('#pesertaTable tbody').on('click', '.btn-edit', function(){
        let row = table.row($(this).parents('tr'));
        let data = row.data();

        $('#menteeModalLabel').text('Edit Mentee');
        $('#rowIndex').val(row.index());
        $('#nama').val($(data[1]).text());
        $('#level').val($(data[2]).text());
        $('#wa').val(data[3]);
        $('#kota').val(data[4]);
        $('#menteeModal').modal('show');
    });

    // Delete
    $('#pesertaTable tbody').on('click', '.btn-delete', function(){
        if(confirm('Yakin ingin menghapus data ini?')){
            table.row($(this).parents('tr')).remove().draw();
        }
    });

    // View Detail
    $('#pesertaTable tbody').on('click', '.btn-view', function(){
        let btn = $(this);
        let nama = btn.data('nama');
        let level = btn.data('level');
        let wa = btn.data('wa');
        let kota = btn.data('kota');
        let keterangan = getLevelDescription(level);

        $('#detailNama').text(nama);
        $('#detailLevel').text(level);
        $('#detailWA').text(wa);
        $('#detailKota').text(kota);
        $('#detailKeterangan').text(keterangan);
    });
});
</script>
@endpush
