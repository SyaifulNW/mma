<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;

class TaskDashboardController extends Controller
{
    public function index()
    {
        // ambil semua materi beserta tahapan, task, dan inisiatif
        $materi = Materi::with(['tahapan.tasks.inisiatif'])->get();

        return view('task.index', compact('materi'));
    }
}
