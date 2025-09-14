<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;

class TaskDashboardController extends Controller
{
    public function index()
{
    

        // Ambil semua materi beserta relasi
        $materi = Materi::with(['tasks.inisiatifs'])->get();
        return view('task.index', compact('materi'));
}

}
