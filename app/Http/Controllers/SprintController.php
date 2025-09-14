<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Sprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SprintController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tasks' => 'required|array|min:1',
            // 'materi' => 'sometimes|array' // opsional
        ]);

        $taskIds = $request->input('tasks', []);
        $saved = collect();

          $userId = Auth::id(); 

        DB::beginTransaction();
        try {
            foreach ($taskIds as $taskId) {
                // ambil task + relation inisiatifs (pastikan nama relation di model Task: inisiatifs)
                $task = Task::with('inisiatifs')->find($taskId);
                if (! $task) continue;

                foreach ($task->inisiatifs as $inisiatif) {
                    // hindari duplikat
                    $exists = Sprint::where('task_id', $task->id)
                                    ->where('inisiatif_id', $inisiatif->id)
                                    ->exists();
                    if ($exists) continue;

                    $sprint = Sprint::create([
                        'task_id' => $task->id,
                        'inisiatif_id' => $inisiatif->id,
                        'status' => 'pending',
                        'mulai' => now(),
                        'selesai' => null,
                               'created_by' => $userId, // isi created_by
                    ]);

                    // eager load relations for response
                    $sprint->load('task.inisiatifs');
                    $saved->push($sprint);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Sprint store error: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error', 'error' => $e->getMessage()], 500);
        }

        // Susun response: array per task dengan daftar inisiatifnya
        $response = $saved
            ->groupBy(fn($s) => $s->task->id)
            ->map(function($group) {
                $task = $group->first()->task;
                return [
                    'task_id' => $task->id,
                    'task_judul' => $task->judul ?? '-',
                    'inisiatifs' => $task->inisiatifs->map(fn($i) => ['id' => $i->id, 'judul' => $i->judul])->values()
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Sprint berhasil disimpan!',
            'inisiatifs' => $response,
        ]);
    }

    public function index()
    {
        $sprints = Sprint::with(['task','inisiatif'])->get();
        return view('sprints.index', compact('sprints'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'tanggal_mulai'   => 'nullable|date',
        'tanggal_selesai' => 'nullable|date',
        'status'          => 'required|string|in:pending,progress,done',
    ]);

    $sprint = Sprint::findOrFail($id);
    $sprint->update($request->only(['tanggal_mulai', 'tanggal_selesai', 'status']));

    return redirect()->route('sprints.index')->with('success', 'Sprint berhasil diupdate.');
}

}
