@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">📚 Pilih  Task</h1>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="wizard-container">

   <!-- Progress Wizard -->
   <div class="wizard-progress mb-4">
       <div class="step active" data-step="1">1</div>
       <div class="line"></div>
       <div class="step" data-step="2">2</div>
       <div class="line"></div>
       <div class="step" data-step="3">3</div>
   </div>

   <!-- Step 1 -->
   <div id="step1" class="wizard-step card p-4 shadow-sm fade-in">
       <h4 class="mb-3">Step 1: Pilih Maksimal 2 Materi</h4>
       <div class="row g-4">
           @foreach ($materi as $m)
           <div class="col-md-4 col-sm-6">
               <div class="card materi-card shadow-sm h-80"
                    data-materi-id="{{ $m->id }}"
                    data-materi-title="{{ $m->judul }}">
                   <div class="check-overlay">
                       <i class="bi bi-check-circle-fill"></i>
                   </div>
                   <div class="card-body">
                       <h5 class="card-title fw-bold">{{ $m->judul }}</h5>
                       <p class="text-muted small">{{ $m->deskripsi ?: 'Belum ada deskripsi' }}</p>
                   </div>
               </div>
           </div>
           @endforeach
       </div>
   </div>

   <!-- Step 2 -->
   <div id="step2" class="wizard-step card p-4 shadow-sm d-none fade-in">
       <h4 class="mb-3">Step 2: Pilih Task</h4>
       <button id="openTaskModal" type="button" class="btn btn-outline-primary">
           📋 Pilih Task
       </button>
       <div id="taskSummary" class="mt-3 text-muted small"></div>
   </div>

   <!-- Modal Task -->
   <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-scrollable">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title">Daftar Task</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body">
           <div class="row">
             <!-- Panel Materi A -->
             <div class="col-md-6 border-end">
               <h6 class="fw-bold">Materi A - HRD</h6>
               <div id="taskListA" style="max-height:400px; overflow-y:auto;" class="list-group"></div>
             </div>
             <!-- Panel Materi B -->
             <div class="col-md-6">
               <h6 class="fw-bold">Materi B - Legal</h6>
               <div id="taskListB" style="max-height:400px; overflow-y:auto;" class="list-group"></div>
             </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
           <button type="button" class="btn btn-primary" id="saveTasks">Simpan Pilihan</button>
         </div>
       </div>
     </div>
   </div>

   <!-- Step 3 -->
   <div id="step3" class="wizard-step card p-4 shadow-sm d-none fade-in">
       <h4 class="mb-3">Step 3: Inisiatif yang Dipilih</h4>
       <div id="inisiatifContainer" class="list-group"></div>
   </div>

   <!-- Navigation Buttons -->
   <div class="wizard-nav bottom mt-4 d-flex justify-content-between align-items-center">
       <button class="btn btn-secondary prevStep">⬅️ Kembali</button>
       <div class="text-muted small">Langkah <span id="currentStepLabel">1</span> dari 3</div>
       <button class="btn btn-primary nextStep">Lanjut ➡️</button>
   </div>
</div>
@endsection

@push('styles')
<style>
.wizard-progress { display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
.wizard-progress .step {
    width: 40px; height: 40px; border-radius: 50%; background: #ddd; color: #555;
    font-weight: bold; display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease-in-out;
}
.wizard-progress .step.active { background: #0d6efd; color: #fff; transform: scale(1.2); }
.wizard-progress .line { flex: 1; height: 4px; background: #ddd; margin: 0 10px; }
.materi-card { position: relative; cursor: pointer; transition: transform 0.15s; padding-left: 50px; }
.materi-card:active { transform: scale(0.96); }
.materi-card .check-overlay {
    position: absolute; top: 50%; left: 15px; transform: translateY(-50%);
    font-size: 22px; color: #28a745; display: none;
}
.materi-card.selected .check-overlay { display: block; }
.wizard-nav.bottom { position: sticky; bottom: 0; background: #fff; padding: 12px 16px; border-top: 1px solid #eee; z-index: 20; }
.fade-in { animation: fadeEffect 0.35s ease-in; }
@keyframes fadeEffect { from {opacity: 0; transform: translateY(8px);} to {opacity: 1; transform: translateY(0);} }
.inisiatif-item { padding: 10px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 8px; background: #f9f9f9; }
.inisiatif-item .doc { font-size: 13px; color: #555; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const maxMateri = 2;
    const maxTask = 4; 
    let currentStep = 1;
    let selectedMateri = [];
    let selectedTasks = [];

    // Ambil data dari Laravel (materi + tasks + inisiatif)
    const materiTasks = @json($materi);

    const steps = document.querySelectorAll(".wizard-step");
    const stepIndicators = document.querySelectorAll(".wizard-progress .step");
    const prevBtn = document.querySelector(".prevStep");
    const nextBtn = document.querySelector(".nextStep");
    const currentStepLabel = document.getElementById("currentStepLabel");

    function goToStep(step) {
        steps.forEach((s, i) => s.classList.toggle("d-none", i !== step - 1));
        stepIndicators.forEach((ind, i) => ind.classList.toggle("active", i === step - 1));
        prevBtn.style.visibility = (step === 1) ? "hidden" : "visible";
        nextBtn.textContent = (step === steps.length) ? "✅ Selesai" : "Lanjut ➡️";
        currentStep = step;
        currentStepLabel.textContent = step;
    }

    // Pilih materi
    document.querySelectorAll(".materi-card").forEach(card => {
        card.addEventListener("click", function () {
            const materiId = parseInt(this.dataset.materiId);
            if (this.classList.contains("selected")) {
                this.classList.remove("selected");
                selectedMateri = selectedMateri.filter(id => id !== materiId);
            } else {
                if (selectedMateri.length >= maxMateri) {
                    Swal.fire("Maksimal " + maxMateri + " Materi", "Anda hanya boleh memilih " + maxMateri + " materi.", "warning");
                    return;
                }
                this.classList.add("selected");
                selectedMateri.push(materiId);
            }
        });
    });

    // Open task modal
    document.getElementById("openTaskModal").addEventListener("click", function () {
        const taskListA = document.getElementById("taskListA");
        const taskListB = document.getElementById("taskListB");
        taskListA.innerHTML = "";
        taskListB.innerHTML = "";

        // Loop materi
        materiTasks.forEach(m => {
            if (!selectedMateri.includes(m.id)) return;

            let container = (taskListA.innerHTML === "") ? taskListA : taskListB;
            m.tasks.forEach((t, i) => {
                const item = document.createElement("label");
                item.className = "list-group-item d-flex align-items-start";
                item.innerHTML = `
                    <input type="checkbox" class="form-check-input me-2 task-check" value="${t.id}">
                    <div>
                        <div class="fw-bold">${i+1}. ${t.judul}</div>
                        <div class="text-muted small">Tujuan: ${t.tujuan ?? '-'}</div>
                    </div>
                `;
                container.appendChild(item);
            });
        });

        new bootstrap.Modal(document.getElementById("taskModal")).show();
    });

    // Save tasks
    document.getElementById("saveTasks").addEventListener("click", function () {
        const checked = Array.from(document.querySelectorAll(".task-check:checked")).map(c => parseInt(c.value));
        if (checked.length > maxTask) {
            Swal.fire("Maksimal " + maxTask + " Task", "Anda hanya boleh pilih " + maxTask + " task.", "warning");
            return;
        }
        selectedTasks = checked;
        document.getElementById("taskSummary").innerText = `Dipilih: ${selectedTasks.length} task`;
        bootstrap.Modal.getInstance(document.getElementById("taskModal")).hide();

        // tampilkan inisiatif di Step 3
        const inisiatifContainer = document.getElementById("inisiatifContainer");
        inisiatifContainer.innerHTML = "";

        materiTasks.forEach(m => {
            m.tasks.forEach(t => {
                if (selectedTasks.includes(t.id)) {
                    const taskDiv = document.createElement("div");
                    taskDiv.className = "mb-3";
                    taskDiv.innerHTML = `<h6 class="fw-bold">${t.judul}</h6>`;
                t.inisiatifs.forEach(ini => {
    const iniDiv = document.createElement("div");
    iniDiv.className = "inisiatif-item";
    iniDiv.innerHTML = `<i class="bi bi-check2-circle text-success"></i> ${ini.judul}`;
    taskDiv.appendChild(iniDiv);
});
                    inisiatifContainer.appendChild(taskDiv);
                }
            });
        });
    });

    // Next button
    nextBtn.addEventListener("click", function () {
        if (currentStep === 1) {
            if (selectedMateri.length === 0) {
                Swal.fire("Pilih Materi", "Anda harus memilih minimal 1 materi.", "warning");
                return;
            }
            goToStep(2);
        } else if (currentStep === 2) {
            if (selectedTasks.length === 0) {
                Swal.fire("Pilih Task", "Anda harus memilih minimal 1 task.", "warning");
                return;
            }
            goToStep(3);
        } else if (currentStep === 3) {
            Swal.fire({
                icon: "success",
                title: "Sprint Tersimpan!",
                text: "Task & inisiatif berhasil ditambahkan."
            }).then(() => {
                window.location.href = "/sprints";
            });
        }
    });

    // Prev button
    prevBtn.addEventListener("click", function () {
        if (currentStep > 1) goToStep(currentStep - 1);
    });

    goToStep(1);
});
</script>

@endpush
    