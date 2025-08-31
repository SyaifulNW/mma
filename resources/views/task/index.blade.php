@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">📚 Materi Mastermind</h1>

<div class="row g-4">
    @foreach ($materi as $mIndex => $m)
    @php
    $totalTask = $m->tahapan->flatMap->tasks->count();
    $totalInisiatif = $m->tahapan->flatMap->tasks->flatMap->inisiatif->count();
    $doneInisiatif = $m->tahapan->flatMap->tasks->flatMap->inisiatif->where('status',1)->count();
    $percent = $totalInisiatif > 0 ? round(($doneInisiatif/$totalInisiatif)*100) : 0;
    @endphp

    <!-- Card Materi -->
    <div class="col-md-4 col-sm-6">
        <div class="card shadow-sm h-100" role="button"
            data-bs-toggle="modal"
            data-bs-target="#materiModal{{ $mIndex }}">
            <div class="card-body">
                <h5 class="card-title fw-bold">{{ $m->judul }}</h5>
                <p class="text-muted small">{{ Str::limit($m->deskripsi, 100) }}</p>

                <div class="mb-2">
                    <span class="badge bg-info">{{ $totalTask }} Task</span>
                    <span class="badge bg-success">{{ $doneInisiatif }}/{{ $totalInisiatif }} Inisiatif</span>
                </div>

                <div class="progress" style="height: 18px;">
                    <div class="progress-bar {{ $percent < 50 ? 'bg-danger' : 'bg-success' }}"
                        role="progressbar" style="width: {{ $percent }}%">
                        {{ $percent }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Materi -->
    <div class="modal fade" id="materiModal{{ $mIndex }}" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ $m->judul }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- Accordion Tahapan -->
                    <div class="accordion" id="accordionTahapan{{ $mIndex }}">
                        @foreach ($m->tahapan as $tIndex => $t)
                        <div class="accordion-item mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed d-flex justify-content-between"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseTahapan{{ $mIndex }}{{ $tIndex }}">
                                    <span>
                                        Tahap {{ $tIndex+1 }}: {{ $t->judul }}
                                        <span class="badge bg-info ms-2">{{ $t->tasks->count() }} Task</span>
                                    </span>
                                    <i class="bi bi-chevron-down ms-auto"></i>
                                </button>
                            </h2>
                            <div id="collapseTahapan{{ $mIndex }}{{ $tIndex }}" class="accordion-collapse collapse">
                                <div class="accordion-body">

                                    <!-- Task List -->
                                    @foreach ($t->tasks as $taskIndex => $task)
                                    @php
                                    $total = $task->inisiatif->count();
                                    $done = $task->inisiatif->where('status', 1)->count();
                                    $percentTask = $total > 0 ? round(($done/$total)*100) : 0;
                                    @endphp
                                    <div class="card mb-3 shadow-sm" data-task-card="{{ $task->id }}">
                                        <div class="card-header bg-secondary text-white d-flex justify-content-between">
                                            <span>{{ $task->judul }}</span>
                                            <span class="badge bg-light text-dark">{{ $done }}/{{ $total }}</span>
                                        </div>
                                        <div class="card-body">
                                            <!-- Progress bar per task -->
                                            <div class="progress mb-3" style="height: 16px;">
                                                <div class="progress-bar {{ $percentTask < 50 ? 'bg-danger' : 'bg-success' }}"
                                                    style="width: {{ $percentTask }}%">
                                                    {{ $percentTask }}%
                                                </div>
                                            </div>

                                            <!-- Inisiatif Table -->
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered align-middle text-center">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="text-start">Inisiatif</th>
                                                            <th class="text-start">Dokumen</th>
                                                            <th>Checklist</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($task->inisiatif as $iIndex => $inisiatif)
                                                        <tr data-task-id="{{ $task->id }}">
                                                            <td>{{ $iIndex+1 }}</td>
                                                            <td class="text-start">{{ $inisiatif->judul }}</td>
                                                            <td class="text-start">{{ $inisiatif->dokumen }}</td>
                                                            <td>
                                                                <input type="checkbox"
                                                                    class="toggle-inisiatif"
                                                                    data-id="{{ $inisiatif->id }}"
                                                                    data-task="{{ $task->id }}"
                                                                    {{ $inisiatif->status ? 'checked' : '' }}>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm btn-warning edit-btn"
                                                                    data-id="{{ $inisiatif->id }}"
                                                                    data-judul="{{ $inisiatif->judul }}"
                                                                    data-dokumen="{{ $inisiatif->dokumen }}">
                                                                    ✏️
                                                                </button>
                                                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $inisiatif->id }}">
                                                                    🗑
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Tambah inisiatif -->
                                            <form method="POST" action="{{ route('inisiatif.store') }}" class="mt-2">
                                                @csrf
                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                <div class="row g-2">
                                                    <div class="col-md-4 col-sm-12">
                                                        <input type="text" name="judul" class="form-control" placeholder="Inisiatif baru" required>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <input type="text" name="dokumen" class="form-control" placeholder="Dokumen" required>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 d-grid">
                                                        <button type="submit" class="btn btn-primary btn-sm">+ Tambah</button>
                                                    </div>
                                                </div>
                                            </form>

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
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("click", function(e) {
        // EDIT
        if (e.target.closest(".edit-btn")) {
            let btn = e.target.closest(".edit-btn");
            let id = btn.dataset.id;
            let judul = btn.dataset.judul;
            let dokumen = btn.dataset.dokumen;

            // isi modal
            document.getElementById("editId").value = id;
            document.getElementById("editJudul").value = judul;
            document.getElementById("editDokumen").value = dokumen;

            let modal = new bootstrap.Modal(document.getElementById("editInisiatifModal"));
            modal.show();
        }

        // DELETE
        if (e.target.closest(".delete-btn")) {
            let btn = e.target.closest(".delete-btn");
            let id = btn.dataset.id;
            if (!confirm("Yakin mau hapus inisiatif ini?")) return;

            fetch(`/api/inisiatif/${id}`, {
                    method: "DELETE",
                    headers: {
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // hapus row tabel
                        btn.closest("tr").remove();
                    }
                });
        }
    });

    // Simpan perubahan edit
    document.getElementById("saveEditBtn").addEventListener("click", function() {
        let id = document.getElementById("editId").value;
        let judul = document.getElementById("editJudul").value;
        let dokumen = document.getElementById("editDokumen").value;

        fetch(`/api/inisiatif/${id}`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    judul,
                    dokumen
                })
            }).then(res => res.json())
            .then(data => {
                if (data.success) {
                    let row = document.querySelector(`[data-id="${id}"]`).closest("tr");
                    row.querySelector("td:nth-child(2)").innerText = data.data.judul;
                    row.querySelector("td:nth-child(3)").innerText = data.data.dokumen;
                    bootstrap.Modal.getInstance(document.getElementById("editInisiatifModal")).hide();
                }
            });
    });
</script>
@endpush

<!-- Script Checklist -->
@push('scripts')
<script>
    // Toggle checklist tanpa reload
    document.addEventListener("change", function(e) {
        if (e.target.classList.contains("toggle-inisiatif")) {
            let id = e.target.dataset.id;
            let status = e.target.checked ? 1 : 0;

            fetch(`/api/inisiatif/toggle/${id}`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        status
                    })
                }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log("✅ Inisiatif updated:", data);
                    } else {
                        alert("Gagal update inisiatif!");
                    }
                }).catch(err => {
                    console.error(err);
                    alert("Terjadi error saat update!");
                });
        }
    });
</script>
@endpush

<!-- Script Task -->
@push('scripts')
<script>
    // Toggle checklist tanpa reload + update progress
document.addEventListener("change", function(e) {
    if (e.target.classList.contains("toggle-inisiatif")) {
        let checkbox = e.target;
        let id = checkbox.dataset.id;
        let status = checkbox.checked ? 1 : 0;
        let taskId = checkbox.dataset.task;

        fetch(`/api/inisiatif/toggle/${id}`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // ✅ Update badge & progress bar
                updateTaskProgress(taskId, data.progress);
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi error saat update!");
        });
    }
});

// Fungsi update progress bar + badge
function updateTaskProgress(taskId, progress) {
    // Cari card task terkait
    let taskCard = document.querySelector(`[data-task-card="${taskId}"]`);
    if (!taskCard) return;

    // Update badge done/total
    let badge = taskCard.querySelector(".task-badge");
    if (badge) badge.innerText = `${progress.done}/${progress.total}`;

    // Update progress bar
    let bar = taskCard.querySelector(".progress-bar");
    if (bar) {
        bar.style.width = progress.percent + "%";
        bar.innerText = progress.percent + "%";
        bar.classList.remove("bg-danger", "bg-success");
        bar.classList.add(progress.percent < 50 ? "bg-danger" : "bg-success");
    }
}

</script>
@endpush