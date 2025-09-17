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
        <div class="d-flex justify-content-between align-items-center">
            <span>📝 {{ $taskSprints->first()->task->judul ?? '-' }}</span>
            <button 
                type="button"
                class="btn btn-sm btn-success tambah-sprint" 
                data-task-id="{{ $taskId }}">
                ➕ Tambah Sprint
            </button>
        </div>
    </td>
</tr>

                    @foreach ($taskSprints as $index => $sprint)
                        <tr data-id="{{ $sprint->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>- {{ $sprint->inisiatif->judul ?? '-' }}</td>

                            {{-- Input tanggal mulai --}}
                            <td>
                                <input 
                                    type="date" 
                                    name="mulai" 
                                    class="form-control form-control-sm sprint-update"
                                    data-id="{{ $sprint->id }}"
                                    value="{{ $sprint->mulai ? \Carbon\Carbon::parse($sprint->mulai)->format('Y-m-d') : '' }}"
                                >
                            </td>

                            {{-- Input tanggal selesai --}}
                            <td>
                                <input 
                                    type="date" 
                                    name="selesai" 
                                    class="form-control form-control-sm sprint-update"
                                    data-id="{{ $sprint->id }}"
                                    value="{{ $sprint->selesai ? \Carbon\Carbon::parse($sprint->selesai)->format('Y-m-d') : '' }}"
                                >
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
                                <span class="badge status-badge {{ $badgeClass }}">
                                    {{ ucfirst($sprint->status) }}
                                </span>
                            </td>

                            {{-- Aksi update status --}}
                            <td>
                                <select 
                                    name="status" 
                                    class="form-select form-select-sm sprint-update"
                                    data-id="{{ $sprint->id }}"
                                >
                                    <option value="pending"  {{ $sprint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="progress" {{ $sprint->status === 'progress' ? 'selected' : '' }}>Progress</option>
                                    <option value="done"     {{ $sprint->status === 'done' ? 'selected' : '' }}>Done</option>
                                </select>
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

    @push('scripts')
    <script>

    document.addEventListener("DOMContentLoaded", () => {
        const token = "{{ csrf_token() }}";

        document.querySelectorAll(".sprint-update").forEach(el => {
            el.addEventListener("change", async (e) => {
                const sprintId = e.target.dataset.id;
                const field = e.target.name;
                const value = e.target.value;

                try {
                    const response = await fetch(`/sprints/${sprintId}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": token,
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({ [field]: value })
                    });

                    const data = await response.json();
                    if (data.success) {
                        // update badge warna kalau status berubah
                        if (field === "status") {
                            const row = e.target.closest("tr");
                            const badge = row.querySelector(".status-badge");

                            badge.textContent = value.charAt(0).toUpperCase() + value.slice(1);

                            badge.classList.remove("bg-success","bg-warning","text-dark","bg-danger");
                            if (value === "done") badge.classList.add("bg-success");
                            else if (value === "progress") badge.classList.add("bg-warning","text-dark");
                            else badge.classList.add("bg-danger");
                        }
                    }
                } catch (err) {
                    console.error("Update error:", err);
                }
            });
        });
    });
    </script>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const token = "{{ csrf_token() }}";

    // Handle update sprint (sudah ada)
    function attachUpdateListeners(el) {
        el.addEventListener("change", async (e) => {
            const sprintId = e.target.dataset.id;
            const field = e.target.name;
            const value = e.target.value;

            try {
                const response = await fetch(`/sprints/${sprintId}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ [field]: value })
                });

                const data = await response.json();
                if (data.success && field === "status") {
                    const row = e.target.closest("tr");
                    const badge = row.querySelector(".status-badge");

                    badge.textContent = value.charAt(0).toUpperCase() + value.slice(1);
                    badge.className = "badge status-badge"; // reset class
                    if (value === "done") badge.classList.add("bg-success");
                    else if (value === "progress") badge.classList.add("bg-warning", "text-dark");
                    else badge.classList.add("bg-danger");
                }
            } catch (err) {
                console.error("Update error:", err);
            }
        });
    }

    document.querySelectorAll(".sprint-update").forEach(attachUpdateListeners);

    // Tambah Sprint
    document.querySelectorAll(".tambah-sprint").forEach(btn => {
        btn.addEventListener("click", async (e) => {
            const taskId = e.currentTarget.dataset.taskId;

            try {
                const response = await fetch("{{ route('sprints.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ task_id: taskId })
                });

                const data = await response.json();
                if (data.success) {
                    const sprint = data.sprint;

                    // Cari baris terakhir sprint di task ini
                    const headerRow = e.currentTarget.closest("tr");
                    let insertAfter = headerRow;
                    let nextRow = headerRow.nextElementSibling;
                    while (nextRow && !nextRow.classList.contains("table-primary")) {
                        insertAfter = nextRow;
                        nextRow = nextRow.nextElementSibling;
                    }

                    // Buat row baru
                    const newRow = document.createElement("tr");
                    newRow.setAttribute("data-id", sprint.id);
                    newRow.innerHTML = `
                        <td>NEW</td>
                        <td>- ${sprint.inisiatif?.judul ?? '-'}</td>
                        <td>
                            <input type="date" name="mulai" class="form-control form-control-sm sprint-update" data-id="${sprint.id}" value="${sprint.mulai ?? ''}">
                        </td>
                        <td>
                            <input type="date" name="selesai" class="form-control form-control-sm sprint-update" data-id="${sprint.id}" value="${sprint.selesai ?? ''}">
                        </td>
                        <td>
                            <span class="badge status-badge bg-danger">Pending</span>
                        </td>
                        <td>
                            <select name="status" class="form-select form-select-sm sprint-update" data-id="${sprint.id}">
                                <option value="pending" selected>Pending</option>
                                <option value="progress">Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </td>
                    `;

                    // Sisipkan setelah row terakhir task
                    insertAfter.insertAdjacentElement("afterend", newRow);

                    // Pasang listener ke elemen baru
                    newRow.querySelectorAll(".sprint-update").forEach(attachUpdateListeners);

                } else {
                    alert(data.message || "Gagal menambahkan sprint");
                }
            } catch (err) {
                console.error("Tambah sprint error:", err);
                alert("Terjadi error saat menambah sprint");
            }
        });
    });
});
</script>

    @endpush
