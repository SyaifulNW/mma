@extends('layouts.dashboard')

@section('content')
<h1 class="mb-4">Task Dashboard All-in-One</h1>

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
                        'nama' => 'Task 1: Menyadari Karyawan adalah Aset Bisnis',
                        'inisiatif' => [
                            ['teks' => 'Adakan workshop internal', 'dokumen'=>'📄 Workshop Material', 'start'=>'2025-09-01','end'=>'2025-09-05'],
                            ['teks' => 'Buat data kontribusi karyawan', 'dokumen'=>'📄 Employee Contribution', 'start'=>'2025-09-03','end'=>'2025-09-07'],
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
            <button class="accordion-button collapsed bg-primary text-white"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseMateri{{ $mIndex }}">
                {{ $m['kode'] }}. {{ $m['nama'] }}
            </button>
        </h2>
        <div id="collapseMateri{{ $mIndex }}" class="accordion-collapse collapse" data-bs-parent="#accordionMateri">
            <div class="accordion-body">
                @foreach ($m['tahapan'] as $tIndex => $t)
                <h5>{{ $t['nama'] }}</h5>
                @foreach ($t['tasks'] as $taskIndex => $task)
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">{{ $task['nama'] }}</div>
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
                                @foreach ($task['inisiatif'] as $iIndex => $inisiatif)
                                <tr>
                                    <td>{{ $iIndex+1 }}</td>
                                    <td class="text-start">{{ $inisiatif['teks'] }}</td>
                                    <td class="text-start">{{ $inisiatif['dokumen'] }}</td>
                                    <td><input type="date" class="form-control timeline-start" value="{{ $inisiatif['start'] }}"></td>
                                    <td><input type="date" class="form-control timeline-end" value="{{ $inisiatif['end'] }}"></td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let ganttChartsAll = {};

function updateProgress(taskId){
    const checks = document.querySelectorAll(`input[data-task='${taskId}']`);
    let checked = 0;
    checks.forEach(c=>{if(c.checked) checked++;});
    const total = checks.length;
    const progress = total? Math.round((checked/total)*100):0;
    const bar = document.getElementById(taskId);
    bar.style.width = progress+"%";
    bar.innerText = progress+"%";
    if(progress<30) bar.className="progress-bar bg-danger";
    else if(progress<70) bar.className="progress-bar bg-warning";
    else bar.className="progress-bar bg-success";
}

function renderGantt(taskId){
    const tbody = document.getElementById('tbodyTask'+taskId);
    const labels = [];
    const data = [];

    Array.from(tbody.rows).forEach(row=>{
        const inisiatif = row.cells[1].innerText;
        const start = row.querySelector('.timeline-start').value;
        const end = row.querySelector('.timeline-end').value;
        if(!start || !end) return;
        labels.push(inisiatif);
        data.push({x:[new Date(start), new Date(end)], y:inisiatif});
    });

    const ctx = document.getElementById('ganttChart'+taskId).getContext('2d');
    if(ganttChartsAll[taskId]) ganttChartsAll[taskId].destroy();

    ganttChartsAll[taskId] = new Chart(ctx, {
        type:'bar',
        data:{
            labels: labels,
            datasets:[{
                label:'Timeline',
                data:data.map(d=>({x:d.x,y:d.y})),
                backgroundColor:'rgba(54,162,235,0.5)'
            }]
        },
        options:{
            indexAxis:'y',
            parsing:{xAxisKey:'x',yAxisKey:'y'},
            scales:{
                x:{type:'time',time:{unit:'day'},title:{display:true,text:'Tanggal'}},
                y:{title:{display:true,text:'Inisiatif'}}
            },
            responsive:true,
            plugins:{legend:{display:false}}
        }
    });
}

function addInisiatifAllInOne(id){
    const tbody = document.getElementById('tbodyTask'+id);
    const teks = document.getElementById('inputInisiatif'+id).value.trim();
    const dok = document.getElementById('inputDokumen'+id).value.trim();
    const start = document.getElementById('inputStart'+id).value;
    const end = document.getElementById('inputEnd'+id).value;
    if(!teks||!start||!end){alert("Isi semua data!"); return;}

    const rowCount = tbody.rows.length+1;
    const row = tbody.insertRow();
    row.innerHTML = `
        <td>${rowCount}</td>
        <td class="text-start">${teks}</td>
        <td class="text-start">${dok}</td>
        <td><input type="date" class="form-control timeline-start" value="${start}"></td>
        <td><input type="date" class="form-control timeline-end" value="${end}"></td>
        <td><input type="checkbox" class="form-check-input checklist" data-task="progressTask${id}"></td>
    `;

    // reset input
    document.getElementById('inputInisiatif'+id).value="";
    document.getElementById('inputDokumen'+id).value="";
    document.getElementById('inputStart'+id).value="";
    document.getElementById('inputEnd'+id).value="";

    // tambah event listener
    row.querySelector('.checklist').addEventListener('change', function(){updateProgress(this.dataset.task);});
    row.querySelector('.timeline-start').addEventListener('change', ()=>renderGantt(id));
    row.querySelector('.timeline-end').addEventListener('change', ()=>renderGantt(id));

    updateProgress('progressTask'+id);
    renderGantt(id);
}

document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".checklist").forEach(chk=>{
        chk.addEventListener("change",function(){updateProgress(this.dataset.task)});
    });
    document.querySelectorAll(".timeline-start, .timeline-end").forEach(input=>{
        const taskId = input.closest("tbody").id.replace('tbodyTask','');
        input.addEventListener('change',()=>renderGantt(taskId));
    });

    // init all charts
    document.querySelectorAll("tbody[id^='tbodyTask']").forEach(tbody=>{
        const id = tbody.id.replace('tbodyTask','');
        renderGantt(id);
        updateProgress('progressTask'+id);
    });
});
</script>
@endpush
