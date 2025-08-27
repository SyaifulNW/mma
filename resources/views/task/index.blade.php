@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">Daftar Task</h1>

@php
$materi = [
    [
        'kode' => 'A',
        'nama' => 'Membangun Bidang HRD',
        'tahapan' => [
            [
                'nama' => 'Tahap 1: Mindset dan Filosofi Pengelolaan SDM',
                'tasks' => [
                    [
                        'nama' => 'Task 1: Workshop People as Assets',
                        'inisiatif' => [
                            'Adakan workshop internal tentang people as assets',
                            'Buat data kontribusi karyawan pada revenue',
                            'Publikasikan kisah sukses karyawan berprestasi',
                        ]
                    ]
                ]
            ]
        ]
    ]
];
@endphp


<div class="accordion" id="accordionMateri">
    @foreach ($materi as $mIndex => $m)
    <div class="accordion-item mb-3">
        <h2 class="accordion-header" id="headingMateri{{ $mIndex }}">
            <button class="accordion-button collapsed bg-primary text-white d-flex justify-content-between align-items-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseMateri{{ $mIndex }}">
                <span>{{ $m['kode'] }}. {{ $m['nama'] }}</span>
                <i class="fas fa-chevron-down ms-2 toggle-icon"></i>
            </button>
        </h2>
        <div id="collapseMateri{{ $mIndex }}" class="accordion-collapse collapse"
             data-bs-parent="#accordionMateri">
            <div class="accordion-body">

                <!-- Tahapan -->
                <div class="accordion" id="accordionTahap{{ $mIndex }}">
                    @foreach ($m['tahapan'] as $tIndex => $t)
                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header" id="headingTahap{{ $mIndex }}{{ $tIndex }}">
                            <button class="accordion-button collapsed bg-light d-flex justify-content-between align-items-center"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTahap{{ $mIndex }}{{ $tIndex }}">
                                <span>{{ $t['nama'] }}</span>
                                <i class="fas fa-chevron-down ms-2 toggle-icon"></i>
                            </button>
                        </h2>
                        <div id="collapseTahap{{ $mIndex }}{{ $tIndex }}" class="accordion-collapse collapse"
                             data-bs-parent="#accordionTahap{{ $mIndex }}">
                            <div class="accordion-body">

                                <!-- Task -->
                                @foreach ($t['tasks'] as $taskIndex => $task)
                                <div class="card mb-3">
                                    <div class="card-header bg-secondary text-white">
                                        {{ $task['nama'] }}
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered mb-0 align-middle text-center">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Inisiatif</th>
                                                    <th>Mulai</th>
                                                    <th>Selesai</th>
                                                    <th>Pilih</th>
                                                    <th>Progress</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($task['inisiatif'] as $iIndex => $inisiatif)
                                                @php $randProgress = rand(10,90); @endphp
                                                <tr>
                                                    <td>{{ $iIndex+1 }}</td>
                                                    <td class="text-start">{{ $inisiatif }}</td>
                                                    <td><input type="date" class="form-control form-control-sm"></td>
                                                    <td><input type="date" class="form-control form-control-sm"></td>
                                                    <td><input type="checkbox"></td>
                                                    <td width="25%">
                                                        <div class="progress" style="height:20px;">
                                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                                                id="progressBar{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}{{ $iIndex }}"
                                                                role="progressbar"
                                                                style="width: {{ $randProgress }}%">
                                                                {{ $randProgress }}%
                                                            </div>
                                                        </div>
                                                        <input type="number" min="0" max="100"
                                                            class="form-control form-control-sm mt-1"
                                                            value="{{ $randProgress }}"
                                                            id="progressInput{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}{{ $iIndex }}">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick="updateProgress('{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}{{ $iIndex }}')">
                                                            Update
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    function updateProgress(id) {
        const input = document.getElementById('progressInput' + id);
        const bar = document.getElementById('progressBar' + id);
        let val = parseInt(input.value);
        if (isNaN(val) || val < 0) val = 0;
        if (val > 100) val = 100;

        bar.style.width = val + "%";
        bar.innerText = val + "%";

        if (val < 30) {
            bar.className = "progress-bar bg-danger";
        } else if (val < 70) {
            bar.className = "progress-bar bg-warning";
        } else {
            bar.className = "progress-bar bg-success";
        }
    }
</script>
@endpush

@push('styles')
<style>
    .toggle-icon {
        transition: transform 0.3s ease;    
    }
    .accordion-button:not(.collapsed) .toggle-icon {
        transform: rotate(180deg);
    }
</style>
@endpush
