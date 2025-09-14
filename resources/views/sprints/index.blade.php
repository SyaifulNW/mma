@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">📌 Daftar Sprint</h1>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th style="width: 50px;">#</th>
                <th>Task & Inisiatif</th>
                <th style="width: 180px;">Mulai</th>
                <th style="width: 180px;">Selesai</th>
                <th style="width: 120px;">Status</th>
                <th style="width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sprints->groupBy('task.id') as $taskId => $taskSprints)
                <tr class="table-primary fw-bold">
                    <td colspan="6">
                        📝 {{ $taskSprints->first()->task->judul ?? '-' }}
                    </td>
                </tr>

                @foreach ($taskSprints as $index => $sprint)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>- {{ $sprint->inisiatif->judul ?? '-' }}</td>

                        {{-- Input tanggal mulai --}}
                        <td>
                            <form action="{{ route('sprints.update', $sprint->id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                @method('PUT')
                                <input 
                                    type="date" 
                                    name="mulai" 
                                    class="form-control form-control-sm"
                                    value="{{ $sprint->mulai ? \Carbon\Carbon::parse($sprint->mulai)->format('Y-m-d') : '' }}"
                                    onchange="this.form.submit()"
                                >
                            </form>
                        </td>

                        {{-- Input tanggal selesai --}}
                        <td>
                            <form action="{{ route('sprints.update', $sprint->id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                @method('PUT')
                                <input 
                                    type="date" 
                                    name="selesai" 
                                    class="form-control form-control-sm"
                                    value="{{ $sprint->selesai ? \Carbon\Carbon::parse($sprint->selesai)->format('Y-m-d') : '' }}"
                                    onchange="this.form.submit()"
                                >
                            </form>
                        </td>

                        {{-- Status dengan warna --}}
                        <td>
                            @php
                                if ($sprint->status === 'done') {
                                    $badgeClass = 'bg-success';
                                } elseif ($sprint->status === 'progress') {
                                    $badgeClass = 'bg-warning text-dark';
                                } else {
                                    $badgeClass = 'bg-danger';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($sprint->status) }}
                            </span>
                        </td>

                        {{-- Aksi update status --}}
                        <td>
                            <form action="{{ route('sprints.update', $sprint->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select 
                                    name="status" 
                                    class="form-select form-select-sm"
                                    onchange="this.form.submit()"
                                >
                                    <option value="pending"  {{ $sprint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="progress" {{ $sprint->status === 'progress' ? 'selected' : '' }}>Progress</option>
                                    <option value="done"     {{ $sprint->status === 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada sprint ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
