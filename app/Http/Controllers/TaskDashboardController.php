<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;

class TaskDashboardController extends Controller
{
    public function index()
{
    // $jsonPath = database_path('seeders/data/materi_A_HRD.json');
    // $materi = json_decode(file_get_contents($jsonPath), true);

    // // Ambil inisiatif tambahan dari DB
    // foreach ($materi['tahapan'] as $tIndex => &$t) {
    //     foreach ($t['tasks'] as $taskIndex => &$task) {
    //         // Cek apakah task ini sudah punya ID di DB
    //         $dbTask = \App\Models\Task::where('judul', $task['judul'])->first();
    //         if ($dbTask) {
    //             $dbInisiatif = \App\Models\Inisiatif::where('task_id', $dbTask->id)->get();
    //             foreach ($dbInisiatif as $item) {
    //                 $task['inisiatif'][] = [
    //                     "judul" => $item->judul,
    //                     "dokumen" => $item->dokumen,
    //                 ];
    //             }
    //         }
    //     }
    // }

    // return view('task.index', compact('materi'));

        // Ambil semua materi beserta relasi
        $materi = Materi::with(['tahapan.tasks.inisiatif'])->get();
        return view('task.index', compact('materi'));
}

}
