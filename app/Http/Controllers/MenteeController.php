<?php

namespace App\Http\Controllers;

use App\Models\Mentee;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;        
use Yajra\DataTables\Facades\DataTables;

class MenteeController extends Controller
{
   public function index()
{
     $mentees = Mentee::with('user')
        ->where('created_by', Auth::id()) // pastikan kamu punya kolom created_by di tabel mentees
        ->get();

    // ambil semua user dengan role mentee
    $users = User::where('role', 'coach')->get();

    return view('peserta.index', compact('mentees', 'users'));
}


 public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'nama'    => 'required',
        'level'   => 'required',
        'wa'      => 'nullable',
        'kota'    => 'nullable',

    ]);

    Mentee::create([
        'user_id' => $request->user_id,
        'nama'    => $request->nama,
        'level'   => $request->level,
        'wa'      => $request->wa,
        'kota'    => $request->kota,
         'created_by' => Auth::id(), // otomatis simpan siapa yang inpu
    ]);

    return redirect()->route('peserta.index')->with('success', 'Mentee berhasil ditambahkan');
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
