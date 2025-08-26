@extends('layouts.app')

@section('content')
<h1 class="mb-4">Daftar Task</h1>

<div class="accordion" id="taskAccordion">
    <!-- Tahap 1 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                Tahap 1: Mindset dan Filosofi Pengelolaan SDM
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#taskAccordion">
            <div class="accordion-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Inisiatif</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Adakan workshop internal tentang people as assets</td>
                            <td>Workshop Material & Attendance List</td>
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 40%">40%</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Buat data kontribusi karyawan pada revenue</td>
                            <td>Employee Contribution Report</td>
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-info" style="width: 70%">70%</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Publikasikan kisah sukses karyawan berprestasi</td>
                            <td>Employee Success Story Sheet</td>
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 10%">10%</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
