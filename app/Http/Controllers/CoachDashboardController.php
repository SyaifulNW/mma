<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentee;
use App\Models\Task;

class CoachDashboardController extends Controller
{
    public function index()
    {
        $coachId = auth()->id();

        // ambil semua mentee dari coach ini
        $mentees = Mentee::where('created_by', $coachId)->with('tasks')->get();

        // Statistik pribadi coach
        $personal = [
            'totalMentee' => $mentees->count(),
            'aktif'       => Task::whereHas('mentee', fn($q) => $q->where('created_by', $coachId))
                                ->where('status', 'aktif')->count(),
            'selesai'     => Task::whereHas('mentee', fn($q) => $q->where('created_by', $coachId))
                                ->where('status', 'selesai')->count(),
            'overdue'     => Task::whereHas('mentee', fn($q) => $q->where('created_by', $coachId))
                                ->where('status', 'overdue')->count(),
        ];

        return view('dashboard.coach', compact('mentees', 'personal'));
    }
}
