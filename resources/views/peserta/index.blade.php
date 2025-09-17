@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Mentee</h1>

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Mentee
    </button>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>   
                <th>Level</th>
                <th>WA</th>
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
                                    <input type="text" name="nama" class="form-control" value="{{ $mentee->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Level</label>
                                    <select id="level" name="level" class="form-control" required>
                                        <option {{ $mentee->level == 'Start-Up' ? 'selected' : '' }}>Start-Up 🚀</option>
                                        <option {{ $mentee->level == 'Stand-Up' ? 'selected' : '' }}>Stand-Up 💪</option>
                                        <option {{ $mentee->level == 'Step-Up' ? 'selected' : '' }}>Step-Up 📈</option>
                                        <option {{ $mentee->level == 'Grow-Up' ? 'selected' : '' }}>Grow-Up 🌱</option>
                                        <option {{ $mentee->level == 'Scale-Up' ? 'selected' : '' }}>Scale-Up 🌍</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>No. WA</label>
                                    <input type="text" name="wa" class="form-control" value="{{ $mentee->wa }}">
                                </div>
                                <div class="mb-3">
                                    <label>Kota</label>
                                    <input type="text" name="kota" class="form-control" value="{{ $mentee->kota }}">
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

<!-- Modal Tambah -->
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
                        <label>Pilih User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                data-nama="{{ $user->name }}"
                                data-email="{{ $user->email }}">
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

                    <!-- Pilih Omset -->
                    <div class="mb-3">
                        <label>Omset</label>
                        <select id="omset" class="form-control" required>
                            <option value="">-- Pilih Omset --</option>
                            <option value="0-100">0 - 100 Juta</option>
                            <option value="100-300">100 - 300 Juta</option>
                            <option value="300-500">300 - 500 Juta</option>
                            <option value="500-1000">500 Juta - 1 M</option>
                            <option value="1000-up">> 1 M</option>
                        </select>
                    </div>

                    <!-- Keterangan Level -->
                    <div class="mb-3">
                        <label>Keterangan Level</label>
                        <input type="text" id="level_text" class="form-control" readonly>
                        <input type="hidden" name="level" id="level">
                    </div>

                    <div class="mb-3">
                        <label>No. WA</label>
                        <input type="text" name="wa" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Provinsi</label>
                        <select id="provinsi" class="form-control" required>
                            <option value="">-- Pilih Provinsi --</option>
                            <option value="Jawa Barat">Jawa Barat</option>
                            <option value="Jawa Tengah">Jawa Tengah</option>
                            <option value="Jawa Timur">Jawa Timur</option>
                            <option value="DKI Jakarta">DKI Jakarta</option>
                            <option value="DI Yogyakarta">DI Yogyakarta</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Kota</label>
                        <select name="kota" id="kota" class="form-control" required>
                            <option value="">-- Pilih Kota --</option>
                        </select>
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
    // Isi otomatis nama & email saat user dipilih
    document.getElementById('user_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        document.getElementById('nama').value = selected.getAttribute('data-nama') || '';
        document.getElementById('email').value = selected.getAttribute('data-email') || '';
    });

    // Tentukan level dari omset
    document.getElementById('omset').addEventListener('change', function() {
        let val = this.value;
        let level = '';
        switch (val) {
            case '0-100':
                level = 'Start-Up 🚀';
                break;
            case '100-300':
                level = 'Stand-Up 💪';
                break;
            case '300-500':
                level = 'Step-Up 📈';
                break;
            case '500-1000':
                level = 'Grow-Up 🌱';
                break;
            case '1000-up':
                level = 'Scale-Up 🌍';
                break;
        }
        document.getElementById('level_text').value = level;
        document.getElementById('level').value = level;
    });

  const kotaByProvinsi = {
        "Jawa Barat": ["Bandung", "Bogor", "Depok", "Bekasi", "Cirebon"],
        "Jawa Tengah": ["Semarang", "Solo", "Magelang", "Purwokerto", "Tegal"],
        "Jawa Timur": ["Surabaya", "Malang", "Kediri", "Madiun", "Jember"],
        "DKI Jakarta": ["Jakarta Selatan", "Jakarta Timur", "Jakarta Barat", "Jakarta Utara", "Jakarta Pusat"],
        "DI Yogyakarta": ["Kota Yogyakarta", "Sleman", "Bantul", "Gunung Kidul", "Kulon Progo"]
    };

    document.getElementById('provinsi').addEventListener('change', function() {
        let provinsi = this.value;
        let kotaSelect = document.getElementById('kota');
        kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';

        if (provinsi && kotaByProvinsi[provinsi]) {
            kotaByProvinsi[provinsi].forEach(kota => {
                let option = document.createElement('option');
                option.value = kota;
                option.textContent = kota;
                kotaSelect.appendChild(option);
            });
        }
    });
</script>


@endsection