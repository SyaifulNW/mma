<?php

namespace App\Http\Controllers;

use App\Models\Mentee;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;        
use Yajra\DataTables\Facades\DataTables;

class MenteeController extends Controller
{
    public function index()
    {
        $mentees = Mentee::with('user')->get();
    return view('mentees.index', compact('mentees'));
    }

    public function store(Request $request)
    {
       // validasi input
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'level' => 'required',
        'wa' => 'nullable',
        'kota' => 'nullable',
    ]);

    // buat user baru
    $user = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'mentee',
    ]);

    // buat mentee baru
    Mentee::create([
        'user_id' => $user->id,
        'nama' => $request->nama,
        'level' => $request->level,
        'wa' => $request->wa,
        'kota' => $request->kota,
    ]);
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
