<?php

namespace App\Http\Controllers;

use App\Models\Mentee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenteeController extends Controller
{
    public function index()
    {
        $mentees = Mentee::all();
        return view('peserta.index', compact('mentees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'level' => 'required',
        ]);

        Mentee::create($request->all());
        return redirect()->route('mentees.index')->with('success', 'Mentee berhasil ditambahkan');
    }

    public function update(Request $request, Mentee $mentee)
    {
        $request->validate([
            'nama' => 'required',
            'level' => 'required',
        ]);

        $mentee->update($request->all());
        return redirect()->route('mentees.index')->with('success', 'Mentee berhasil diubah');
    }

    public function destroy(Mentee $mentee)
    {
        $mentee->delete();
        return redirect()->route('mentees.index')->with('success', 'Mentee berhasil dihapus');
    }
}
