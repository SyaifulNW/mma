@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Mentee</h1>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Mentee
    </button>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Level</th>
                <!-- <th>Omset</th> -->
                <th>WA</th>
                <th>Kota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mentees as $mentee)
            <tr>
                <td>{{ $mentee->user->name }}</td>
                <td>{{ $mentee->user->email }}</td>
                <td>{{ $mentee->level }}</td>
                <!-- <td>{{ $mentee->omset }}</td> -->
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
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ $mentee->user->name }}">
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="{{ $mentee->user->email }}">
                                </div>
                                <div class="mb-3">
                                    <label>Omset</label>
                                    <select name="omset" class="form-control omset-select" data-target="{{ $mentee->id }}">
                                        <option value="">-- Pilih Omset --</option>
                                        <option value="0-100" {{ $mentee->omset == '0-100' ? 'selected' : '' }}>0 - 100 Juta</option>
                                        <option value="100-300" {{ $mentee->omset == '100-300' ? 'selected' : '' }}>100 - 300 Juta</option>
                                        <option value="300-500" {{ $mentee->omset == '300-500' ? 'selected' : '' }}>300 - 500 Juta</option>
                                        <option value="500-1000" {{ $mentee->omset == '500-1000' ? 'selected' : '' }}>500 Juta - 1 M</option>
                                        <option value="1000-up" {{ $mentee->omset == '1000-up' ? 'selected' : '' }}>> 1 M</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Level</label>
                                    <input type="text" id="level_text_{{ $mentee->id }}" class="form-control" 
                                           value="{{ $mentee->level }}" readonly>
                                    <input type="hidden" name="level" id="level_{{ $mentee->id }}" value="{{ $mentee->level }}">
                                </div>
                                <div class="mb-3">
                                    <label>No. WA</label>
                                    <input type="text" name="wa" class="form-control" 
                                           value="{{ $mentee->wa }}">
                                </div>
                                <div class="mb-3">
                                    <label>Kota</label>
                                    <input type="text" name="kota" class="form-control" 
                                           value="{{ $mentee->kota }}">
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
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Omset</label>
                        <select id="omsetTambah" name="omset" class="form-control" required>
                            <option value="">-- Pilih Omset --</option>
                            <option value="0-100">0 - 100 Juta</option>
                            <option value="100-300">100 - 300 Juta</option>
                            <option value="300-500">300 - 500 Juta</option>
                            <option value="500-1000">500 Juta - 1 M</option>
                            <option value="1000-up">> 1 M</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Level</label>
                        <input type="text" id="level_text_tambah" class="form-control" readonly>
                        <input type="hidden" name="level" id="level_tambah">
                    </div>

                    <div class="mb-3">
                        <label>No. WA</label>
                        <input type="text" name="wa" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Kota</label>
                        <input type="text" name="kota" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function getLevel(val) {
    switch (val) {
        case '0-100': return 'Start-Up 🚀';
        case '100-300': return 'Stand-Up 💪';
        case '300-500': return 'Step-Up 📈';
        case '500-1000': return 'Grow-Up 🌱';
        case '1000-up': return 'Scale-Up 🌍';
        default: return '';
    }
}

// Untuk modal tambah
document.getElementById('omsetTambah').addEventListener('change', function() {
    let level = getLevel(this.value);
    document.getElementById('level_text_tambah').value = level;
    document.getElementById('level_tambah').value = level;
});

// Untuk modal edit (dinamis banyak mentee)
document.querySelectorAll('.omset-select').forEach(select => {
    select.addEventListener('change', function() {
        let id = this.dataset.target;
        let level = getLevel(this.value);
        document.getElementById('level_text_' + id).value = level;
        document.getElementById('level_' + id).value = level;
    });
});
</script>
@endpush
