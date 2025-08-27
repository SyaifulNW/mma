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
                        'nama' => 'Task 1: Menyadari Bahwa Karyawan adalah Aset Bisnis, Bukan Beban',
                        'inisiatif' => [
                            ['teks' => 'Adakan workshop internal tentang people as assets', 'dokumen' => '📄 Workshop Material & Attendance List'],
                            ['teks' => 'Buat data kontribusi karyawan pada revenue', 'dokumen' => '📄 Employee Contribution Report'],
                            ['teks' => 'Publikasikan kisah sukses karyawan berprestasi', 'dokumen' => '📄 Employee Success Story Sheet'],
                            ['teks' => 'Buat program penghargaan bulanan/tahunan', 'dokumen' => '📄 Employee Award Policy'],
                            ['teks' => 'Tetapkan indikator ROI SDM', 'dokumen' => '📄 HR ROI Calculation Template'],
                            ['teks' => 'Bandingkan biaya turnover dengan biaya pengembangan', 'dokumen' => '📄 Turnover Cost Analysis'],
                            ['teks' => 'Adakan sesi sharing dengan karyawan senior', 'dokumen' => '📄 Sharing Session Notes'],
                            ['teks' => 'Dokumentasikan kontribusi karyawan di proyek penting', 'dokumen' => '📄 Project Contribution Log'],
                            ['teks' => 'Masukkan pencapaian SDM di laporan manajemen', 'dokumen' => '📄 HR Achievement Report'],
                            ['teks' => 'Lakukan survei persepsi manajemen tentang SDM', 'dokumen' => '📄 HR Perception Survey Result'],
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
                                    <div class="card-body">
                                        <!-- Progress bar -->
                                        <div class="progress mb-3" style="height: 25px;">
                                            <div class="progress-bar bg-danger"
                                                id="progressTask{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}"
                                                role="progressbar"
                                                style="width: 0%">
                                                0%
                                            </div>
                                        </div>

                                        <table class="table table-bordered mb-0 align-middle text-center">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Inisiatif</th>
                                                    <th>Dokumen</th>
                                                    <th>Checklist</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyTask{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                                                @foreach ($task['inisiatif'] as $iIndex => $inisiatif)
                                                <tr>
                                                    <td>{{ $iIndex+1 }}</td>
                                                    <td class="text-start">{{ $inisiatif['teks'] }}</td>
                                                    <td class="text-start">{{ $inisiatif['dokumen'] }}</td>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input checklist"
                                                            data-task="progressTask{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Tambah inisiatif lain -->
                                        <div class="mt-3">
                                            <input type="text" class="form-control mb-2"
                                                   placeholder="Tulis inisiatif lain..."
                                                   id="inputInisiatif{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                                            <input type="text" class="form-control mb-2"
                                                   placeholder="Tulis dokumen (opsional)..."
                                                   id="inputDokumen{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="addInisiatif('{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}')">
                                                + Tambah Inisiatif
                                            </button>
                                        </div>
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
    function updateProgress(taskId) {
        const taskChecks = document.querySelectorAll(`input[data-task='${taskId}']`);
        let checked = 0;
        taskChecks.forEach(c => { if (c.checked) checked++; });

        const total = taskChecks.length;
        const progress = total ? Math.round((checked / total) * 100) : 0;
        const bar = document.getElementById(taskId);

        bar.style.width = progress + "%";
        bar.innerText = progress + "%";

        if (progress < 30) {
            bar.className = "progress-bar bg-danger";
        } else if (progress < 70) {
            bar.className = "progress-bar bg-warning";
        } else {
            bar.className = "progress-bar bg-success";
        }
    }

    function addInisiatif(id) {
        const tbody = document.getElementById('tbodyTask' + id);
        const teks = document.getElementById('inputInisiatif' + id).value.trim();
        const dok = document.getElementById('inputDokumen' + id).value.trim();

        if (!teks) {
            alert("Isi dulu inisiatif lain!");
            return;
        }

        const rowCount = tbody.rows.length + 1;
        const row = tbody.insertRow();

        row.innerHTML = `
            <td>${rowCount}</td>
            <td class="text-start">${teks}</td>
            <td class="text-start">${dok ? dok : '-'}</td>
            <td><input type="checkbox" class="form-check-input checklist" data-task="progressTask${id}"></td>
        `;

        // reset input
        document.getElementById('inputInisiatif' + id).value = "";
        document.getElementById('inputDokumen' + id).value = "";

        // tambahkan event listener untuk checkbox baru
        row.querySelector(".checklist").addEventListener("change", function() {
            updateProgress(this.dataset.task);
        });

        updateProgress("progressTask" + id);
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".checklist").forEach(chk => {
            chk.addEventListener("change", function() {
                updateProgress(this.dataset.task);
            });
        });
    });
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
