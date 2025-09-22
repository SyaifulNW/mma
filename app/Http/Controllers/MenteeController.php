<?php

namespace App\Http\Controllers;

use App\Models\Mentee;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MenteeController extends Controller
{
    public function index()
    {
        // hanya mentee yang dibuat oleh coach login
        $mentees = Mentee::with('user')
            ->where('created_by', Auth::id())
            ->get();

        return view('peserta.index', compact('mentees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'omset'    => 'required|string',
            'level'    => 'required|string',
            'wa'       => 'nullable|string',
            'kota'     => 'nullable|string',
        ]);

        // buat akun user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'omset'    => $request->omset,
            'level'    => $request->level,
            'wa'       => $request->wa,
            'kota'     => $request->kota,
            'role'     => 'mentee', // <- kalau ini khusus mentee, role jangan 'coach'
        ]);

        // simpan detail mentee
        Mentee::create([
            'user_id'    => $user->id,
                'nama'       => $request->name, // tambahkan ini
            'omset'      => $request->omset,
            'level'      => $request->level,
            'wa'         => $request->wa,
            'kota'       => $request->kota,
            'created_by' => Auth::id(), // coach yang buat
        ]);

        return redirect()->route('peserta.index')->with('success', 'Mentee berhasil ditambahkan');
    }

    public function update(Request $request, Mentee $mentee)
    {
        // hanya bisa update mentee yang dibuat oleh coach login
        if ($mentee->created_by != Auth::id()) {
            abort(403, 'Tidak punya akses');
        }

        $request->validate([
            'omset' => 'required|string',
            'level' => 'required|string',
            'wa'    => 'nullable|string',
            'kota'  => 'nullable|string',
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $mentee->user_id,
        ]);

        $mentee->update([
            'omset' => $request->omset,
            'level' => $request->level,
            'wa'    => $request->wa,
            'kota'  => $request->kota,
        ]);

        // update juga di tabel user
        $mentee->user->update([
            'name'  => $request->name ?? $mentee->user->name,
            'email' => $request->email ?? $mentee->user->email,
            'omset' => $request->omset,
            'level' => $request->level,
            'wa'    => $request->wa,
            'kota'  => $request->kota,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Mentee berhasil diubah');
    }

    public function destroy(Mentee $mentee)
    {
        // hanya bisa hapus mentee yang dibuat oleh coach login
        if ($mentee->created_by != Auth::id()) {
            abort(403, 'Tidak punya akses');
        }

        // hapus user mentee juga
        $mentee->user->delete();
        $mentee->delete();

        return redirect()->route('peserta.index')->with('success', 'Mentee berhasil dihapus');
    }
}
