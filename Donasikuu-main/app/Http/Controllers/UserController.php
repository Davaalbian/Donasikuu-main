<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class UserController extends Controller
{
    // LIST DATA PENGGUNA (ADMIN)
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->latest()
            ->get();

        return view('pages.data_pengguna.index', compact('users'));
    }

    // FORM EDIT DATA PENGGUNA (ADMIN)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.data_pengguna.edit', compact('user'));
    }

    // UPDATE DATA PENGGUNA (ADMIN)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $id,
            'no_telp'=> 'nullable|string|max:20',
            'alamat' => 'nullable|string|min:15|max:255',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'no_telp' => $request->no_telp,
            'alamat'  => $request->alamat,
        ]);

        return redirect()->route('data_pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // HAPUS DATA PENGGUNA (ADMIN)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data_pengguna.index')
            ->with('success', 'Data pengguna berhasil dihapus!');
    }

    // EDIT PROFIL (DONATUR)
    public function editProfil()
    {
        $user = Auth::user();
        return view('pages.donatur.profil', compact('user'));
    }

    // UPDATE PROFIL (DONATUR)
    public function updateProfil(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'no_telp'        => 'nullable|string|max:20',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat'         => 'nullable|string|min:15|max:255',
            'rt'             => 'nullable|string|max:5',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->update([
            'name'           => $request->name,
            'email'          => $request->email,
            'no_telp'        => $request->no_telp,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'alamat'         => $request->alamat,
            'rt'             => $request->rt,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // ======================================================
    // CETAK PDF (PREVIEW DULU)
    // ======================================================
    public function cetakPdf()
    {
        $users = User::all();

        $pdf = Pdf::loadView('pages.data_pengguna.pdf', compact('users'));

        return $pdf->stream('laporan-pengguna.pdf'); // preview dulu
    }
}