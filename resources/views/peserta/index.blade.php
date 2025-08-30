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
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Level</label>
                        <select id="level" name="level" class="form-control" required>
                            <option value="level">-- Pilih Level --</option>
                            <option>Start-Up</option>
                            <option>Stand-Up</option>
                            <option>Step-Up</option>
                            <option>Grow-Up</option>
                            <option>Scale-Up</option>
                        </select>
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
