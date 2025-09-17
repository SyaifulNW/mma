@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Mentee</h1>

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Mentee
    </button>

<!-- Tambah Tombol Buat Grup -->
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalGroup">
    Buat Grup
</button>



<!-- Modal Buat Grup -->
<div class="modal fade" id="modalGroup" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Grup (maks. 10 mentee)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="checkboxMentees">
                    @foreach ($mentees as $mentee)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $mentee->nama }}" id="mentee{{ $mentee->id }}">
                            <label class="form-check-label" for="mentee{{ $mentee->id }}">
                                {{ $mentee->nama }} - {{ $mentee->level }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="simpanGroup()">Simpan Grup</button>
            </div>
        </div>
    </div>
</div>



    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Level</th>
                <th>WA</th>
                <!-- <th>Provinsi</th> -->
                <th>Kota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mentees as $mentee)
            <tr>
                <td>{{ $mentee->nama }}</td>
                <td>{{ $mentee->level }}</td>
                <td>{{ $mentee->wa }}</td>
                <!-- <td>{{ $mentee->provinsi }}</td> -->
                <td>{{ $mentee->kota }}</td>
                <td>
                    <!-- Tombol Edit -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalEdit{{ $mentee->id }}">
                        Edit
                    </button>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('mentees.destroy', $mentee->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $mentee->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('mentees.update', $mentee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Mentee</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $mentee->nama }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ $mentee->email }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Omset</label>
                                    <input type="text" name="omset" class="form-control" value="{{ $mentee->omset }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Keterangan Level</label>
                                    <input type="text" name="level" class="form-control" value="{{ $mentee->level }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>No. WA</label>
                                    <input type="text" name="wa" class="form-control" value="{{ $mentee->wa }}">
                                </div>
                                <div class="mb-3">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" value="{{ $mentee->provinsi }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Kota</label>
                                    <input type="text" name="kota" class="form-control" value="{{ $mentee->kota }}" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Daftar Grup -->
<div class="card mt-4">
    <div class="card-header fw-bold">Daftar Grup</div>
    <div class="card-body">
        <ul id="listGroups"></ul>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('mentees.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Mentee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Pilih User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                data-nama="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-omset="{{ $user->omset }}"
                                data-level="{{ $user->level }}"
                                data-wa="{{ $user->wa }}"
                                data-provinsi="{{ $user->provinsi }}"
                                data-kota="{{ $user->kota }}">
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="text" id="email" name="email" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Omset</label>
                        <input type="text" id="omset" name="omset" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan Level</label>
                        <input type="text" id="level" name="level" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>No. WA</label>
                        <input type="text" id="wa" name="wa" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Provinsi</label>
                        <input type="text" id="provinsi" name="provinsi" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Kota</label>
                        <input type="text" id="kota" name="kota" class="form-control" readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('user_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        document.getElementById('nama').value = selected.getAttribute('data-nama') || '';
        document.getElementById('email').value = selected.getAttribute('data-email') || '';
        document.getElementById('omset').value = selected.getAttribute('data-omset') || '';
        document.getElementById('level').value = selected.getAttribute('data-level') || '';
        document.getElementById('wa').value = selected.getAttribute('data-wa') || '';
        document.getElementById('provinsi').value = selected.getAttribute('data-provinsi') || '';
        document.getElementById('kota').value = selected.getAttribute('data-kota') || '';
    });

    // Tambah group
    let groups = [];
function simpanGroup() {
    let checked = [...document.querySelectorAll('#checkboxMentees input:checked')].map(cb => cb.value);

    if (checked.length === 0) {
        alert("Pilih minimal 1 mentee!");
        return;
    }
    if (checked.length > 10) {
        alert("Maksimal 10 mentee per grup!");
        return;
    }

    groups.push(checked);
    renderGroups();

    // Tutup modal dengan cara yang aman
    let modalEl = document.getElementById('modalGroup');
    let modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }

    // Hapus backdrop manual kalau masih ada
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

    // Reset centang
    document.querySelectorAll('#checkboxMentees input').forEach(cb => cb.checked = false);
}

    function renderGroups() {
        let ul = document.getElementById('listGroups');
        ul.innerHTML = "";
        groups.forEach((g, i) => {
            ul.innerHTML += `<li><strong>Grup ${i+1}:</strong> ${g.join(", ")}</li>`;
        });
    }
</script>

@endsection
