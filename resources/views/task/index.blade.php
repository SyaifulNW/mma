@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">Task Dashboard All-in-One</h1>

<div class="accordion" id="accordionMateri">
    @foreach ($materi as $mIndex => $m)
    <div class="accordion-item mb-3">
        <h2 class="accordion-header" id="headingMateri{{ $mIndex }}">
            <button class="accordion-button collapsed bg-primary text-white"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseMateri{{ $mIndex }}">
                {{ $m->kode }}. {{ $m->judul }}
            </button>
        </h2>
        <div id="collapseMateri{{ $mIndex }}" class="accordion-collapse collapse" data-bs-parent="#accordionMateri">
            <div class="accordion-body">
                @foreach ($m->tahapan as $tIndex => $t)
                <h5>{{ $t->judul }}</h5>
                @foreach ($t->tasks as $taskIndex => $task)
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">{{ $task->judul }}</div>
                    <div class="card-body">
                        <!-- Progress bar -->
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-danger"
                                 id="progressTask{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}"
                                 role="progressbar"
                                 style="width: 0%">0%</div>
                        </div>

                        <!-- Tabel inisiatif -->
                        <table class="table table-bordered mb-3 align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Inisiatif</th>
                                    <th>Dokumen</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Checklist</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyTask{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                                @foreach ($task->inisiatif as $iIndex => $inisiatif)
                                <tr>
                                    <td>{{ $iIndex+1 }}</td>
                                    <td class="text-start">{{ $inisiatif->judul }}</td>
                                    <td class="text-start">{{ $inisiatif->dokumen }}</td>
                                    <td><input type="date" class="form-control timeline-start" value="{{ $inisiatif->start ?? '' }}"></td>
                                    <td><input type="date" class="form-control timeline-end" value="{{ $inisiatif->end ?? '' }}"></td>
                                    <td><input type="checkbox" class="form-check-input checklist" data-task="progressTask{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Tambah inisiatif baru -->
                        <div class="mt-3 d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Inisiatif" id="inputInisiatif{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                            <input type="text" class="form-control" placeholder="Dokumen" id="inputDokumen{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                            <input type="date" class="form-control" id="inputStart{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                            <input type="date" class="form-control" id="inputEnd{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}">
                            <button class="btn btn-sm btn-primary" onclick="addInisiatifAllInOne('{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}')">+ Tambah</button>
                        </div>

                        <!-- Gantt chart -->
                        <canvas id="ganttChart{{ $mIndex }}{{ $tIndex }}{{ $taskIndex }}" height="150" class="mt-3"></canvas>

                    </div>
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')

<script>
    // Hitung ulang progress bar berdasarkan checklist
    function updateProgress(taskId) {
        let tbody = document.getElementById("tbodyTask" + taskId);
        let checkboxes = tbody.querySelectorAll(".checklist");
        let checked = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) checked++;
        });

        let percent = checkboxes.length > 0 ? Math.round((checked / checkboxes.length) * 100) : 0;
        let progressBar = document.getElementById("progressTask" + taskId);
        progressBar.style.width = percent + "%";
        progressBar.innerText = percent + "%";
    }

    // Event listener untuk checklist
    document.addEventListener("change", function (e) {
        if (e.target.classList.contains("checklist")) {
            let taskId = e.target.getAttribute("data-task").replace("progressTask", "");
            updateProgress(taskId);
        }
    });

    // Tambah inisiatif baru
    function addInisiatifAllInOne(taskId) {
        let tbody = document.getElementById("tbodyTask" + taskId);
        let inputInisiatif = document.getElementById("inputInisiatif" + taskId);
        let inputDokumen = document.getElementById("inputDokumen" + taskId);
        let inputStart = document.getElementById("inputStart" + taskId);
        let inputEnd = document.getElementById("inputEnd" + taskId);

        let rowCount = tbody.rows.length + 1;

        let row = tbody.insertRow();
        row.innerHTML = `
            <td>${rowCount}</td>
            <td class="text-start">${inputInisiatif.value}</td>
            <td class="text-start">${inputDokumen.value}</td>
            <td><input type="date" class="form-control timeline-start" value="${inputStart.value}"></td>
            <td><input type="date" class="form-control timeline-end" value="${inputEnd.value}"></td>
            <td>
                <input type="checkbox" class="form-check-input checklist" data-task="progressTask${taskId}">
                <button class="btn btn-sm btn-danger ms-2" onclick="deleteRow(this, '${taskId}')">Hapus</button>
            </td>
        `;

        // Reset input
        inputInisiatif.value = "";
        inputDokumen.value = "";
        inputStart.value = "";
        inputEnd.value = "";
    }

    // Hapus row inisiatif
    function deleteRow(btn, taskId) {
        let row = btn.closest("tr");
        row.remove();

        // Re-index nomor urut
        let tbody = document.getElementById("tbodyTask" + taskId);
        Array.from(tbody.rows).forEach((row, index) => {
            row.cells[0].innerText = index + 1;
        });

        // Update progress setelah hapus
        updateProgress(taskId);
    }
</script>
@endpush

