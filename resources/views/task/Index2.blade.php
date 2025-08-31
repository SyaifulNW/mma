@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">📚 Daftar Materi</h1>

<div class="accordion" id="accordionMateri">
    @foreach ($materi as $mIndex => $m)
    <div class="accordion-item mb-3">
        <h2 class="accordion-header" id="headingMateri{{ $mIndex }}">
            <button class="accordion-button collapsed bg-primary text-white"
                type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseMateri{{ $mIndex }}">
                {{ $m->judul }}
            </button>
        </h2>

        <div id="collapseMateri{{ $mIndex }}" class="accordion-collapse collapse" data-bs-parent="#accordionMateri">
            <div class="accordion-body">

                @foreach ($m->tahapan as $tIndex => $t)
                <h5 class="mt-3">Tahap {{ $tIndex+1 }}: {{ $t->judul }}</h5>

                @foreach ($t->tasks as $taskIndex => $task)
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        {{ $task->judul }}
                    </div>
                    <div class="card-body">

                        <!-- Progress bar -->
                        @php
                            $total = $task->inisiatif->count();
                            $done = $task->inisiatif->where('status', 1)->count();
                            $percent = $total > 0 ? round(($done/$total)*100) : 0;
                        @endphp
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar {{ $percent < 50 ? 'bg-danger' : 'bg-success' }}"
                                role="progressbar" style="width: {{ $percent }}%">
                                {{ $percent }}%
                            </div>
                        </div>

                        <!-- Tabel inisiatif -->
                        <table class="table table-bordered mb-3 align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Inisiatif</th>
                                    <th>Dokumen</th>
                                    <th>Checklist</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($task->inisiatif as $iIndex => $inisiatif)
                                <tr>
                                    <td>{{ $iIndex+1 }}</td>
                                    <td class="text-start">{{ $inisiatif->judul }}</td>
                                    <td class="text-start">{{ $inisiatif->dokumen }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('inisiatif.toggle', $inisiatif->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="checkbox" onchange="this.form.submit()" {{ $inisiatif->status ? 'checked' : '' }}>
                                        </form>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn"
                                            data-id="{{ $inisiatif->id }}"
                                            data-judul="{{ $inisiatif->judul }}"
                                            data-dokumen="{{ $inisiatif->dokumen }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $inisiatif->id }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Tambah inisiatif -->
                        <form method="POST" action="{{ route('inisiatif.store') }}">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <div class="d-flex gap-2">
                                <input type="text" name="judul" class="form-control" placeholder="Inisiatif baru" required>
                                <input type="text" name="dokumen" class="form-control" placeholder="Dokumen" required>
                                <button type="submit" class="btn btn-sm btn-primary">+ Tambah</button>
                            </div>
                        </form>

                    </div>
                </div>
                @endforeach

                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Edit Inisiatif (global, cukup 1 kali) -->
<div class="modal fade" id="editInisiatifModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Inisiatif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" id="editJudul" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Dokumen</label>
                    <input type="text" id="editDokumen" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveEditBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("click", function(e) {
    // buka modal edit
    if (e.target.classList.contains("edit-btn")) {
        let id = e.target.dataset.id;
        let judul = e.target.dataset.judul;
        let dokumen = e.target.dataset.dokumen;

        document.getElementById("editId").value = id;
        document.getElementById("editJudul").value = judul;
        document.getElementById("editDokumen").value = dokumen;

        let modal = new bootstrap.Modal(document.getElementById("editInisiatifModal"));
        modal.show();
    }

    // hapus inisiatif
    if (e.target.classList.contains("delete-btn")) {
        let id = e.target.dataset.id;
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
                  document.querySelector(`button[data-id="${id}"]`).closest("tr").remove();
              }
          });
    }
});

// simpan perubahan edit
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
        body: JSON.stringify({ judul, dokumen })
    }).then(res => res.json())
      .then(data => {
          if (data.success) {
              let row = document.querySelector(`button[data-id="${id}"]`).closest("tr");
              row.querySelector("td:nth-child(2)").innerText = data.data.judul;
              row.querySelector("td:nth-child(3)").innerText = data.data.dokumen;
              bootstrap.Modal.getInstance(document.getElementById("editInisiatifModal")).hide();
          }
      });
});
</script>
@endpush
