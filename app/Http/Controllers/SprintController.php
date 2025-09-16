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
                        'created_by'  => Auth::id(), // <- ini kunci
                    ]);

                    // eager load relations for response
                    $sprint->load('task.inisiatifs');
                    $saved->push($sprint);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Sprint store error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error', 'error' => $e->getMessage()], 500);
        }

        // Susun response: array per task dengan daftar inisiatifnya
        $response = $saved
            ->groupBy(fn($s) => $s->task->id)
            ->map(function ($group) {
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
        $sprints = Sprint::with(['task', 'inisiatif'])
            ->where('created_by', Auth::id()) // hanya sprint milik user login
            ->get();

        return view('sprints.index', compact('sprints'));
    }

    public function update(Request $request, $id)
    {
        $sprint = Sprint::findOrFail($id);

        $validated = $request->validate([
            'mulai'   => 'nullable|date',
            'selesai' => 'nullable|date|after_or_equal:mulai',
            'status'  => 'nullable|in:pending,progress,done',
        ]);

        if ($request->has('mulai')) $sprint->mulai = $validated['mulai'];
        if ($request->has('selesai')) $sprint->selesai = $validated['selesai'];
        if ($request->has('status')) $sprint->status = $validated['status'];

        $sprint->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Sprint berhasil diperbarui']);
        }

        return redirect()->route('sprints.index')->with('success', 'Sprint berhasil diperbarui!');
    }

    public function gantt()
    {
        $sprints = Sprint::with(['task', 'inisiatif'])
        ->where('created_by', Auth::id()) // filter sprint user login
        ->whereNotNull('mulai')
        ->whereNotNull('selesai')
        ->get()
        ->map(function ($sprint) {
            return [
                'task' => $sprint->task ? $sprint->task->judul : '',
                'inisiatif' => $sprint->inisiatif ? $sprint->inisiatif->judul : '',
                'mulai' => $sprint->mulai ? \Carbon\Carbon::parse($sprint->mulai)->format('Y-m-d') : null,
                'selesai' => $sprint->selesai ? \Carbon\Carbon::parse($sprint->selesai)->format('Y-m-d') : null,
                'status' => $sprint->status,
            ];
        });

    return view('sprints.gantt', compact('sprints'));
    }
}
