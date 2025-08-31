<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inisiatif;

class InisiatifController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'judul' => 'required|string|max:255',
            'dokumen' => 'required|string|max:255',
        ]);

        Inisiatif::create([
            'task_id' => $request->task_id,
            'judul' => $request->judul,
            'dokumen' => $request->dokumen,
            'status' => 0,
        ]);

        return back()->with('success', 'Inisiatif berhasil ditambahkan');
    }

    public function toggle($id)
    {
        $inisiatif = Inisiatif::findOrFail($id);
        $inisiatif->status = !$inisiatif->status;
        $inisiatif->save();

        return back();
    }

    public function toggleApi(Request $request, $id)
{
    $inisiatif = Inisiatif::findOrFail($id);
    $inisiatif->status = $request->input('status', !$inisiatif->status);
    $inisiatif->save();

    $task = $inisiatif->task;
    $total = $task->inisiatif->count();
    $done = $task->inisiatif->where('status', 1)->count();
    $percent = $total > 0 ? round(($done / $total) * 100) : 0;

    return response()->json([
        'success' => true,
        'data' => $inisiatif,
        'progress' => [
            'done' => $done,
            'total' => $total,
            'percent' => $percent
        ]
    ]);
}
}



