<?php

namespace App\Http\Controllers;

use App\Models\DataDonasi;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataDonasiController extends Controller
{
    // =====================================================
    // INDEX (ADMIN & USER)
    // =====================================================
    public function index(Request $request)
    {
        $search = $request->get('search');
        $rt = $request->get('rt');

        if ($rt && str_contains($rt, 'RT')) {
            $rt = str_replace('RT ', '', $rt);
        }

        // ----------------------------
        // HITUNG DATA PER RT
        // ----------------------------
        $rtCounts = [];
        for ($i = 1; $i <= 6; $i++) {
            $rtValue = str_pad($i, 2, '0', STR_PAD_LEFT);

            $rtCounts[$rtValue] = DataDonasi::whereHas('user', function ($q) use ($rtValue) {
                $q->where('rt', $rtValue);
            })->count();
        }

        // ----------------------------
        // ROLE CHECK (FIX UTAMA)
        // ----------------------------
        $query = DataDonasi::with(['user', 'kategori']);

        if (Auth::check() && Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // ----------------------------
        // SEARCH
        // ----------------------------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%$search%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%$search%");
                  });
            });
        }

        // ----------------------------
        // FILTER RT
        // ----------------------------
        if ($rt) {
            $query->whereHas('user', function ($q) use ($rt) {
                $q->where('rt', $rt);
            });
        }

        $data_donasi = $query->latest()->get();

        return view('pages.data_donasi.index', compact(
            'data_donasi',
            'rtCounts',
            'rt'
        ));
    }

    public function create()
    {
        $users = User::all();
        $kategori = Kategori::all();

        return view('pages.data_donasi.create', compact('users', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'        => 'required|exists:kategoris,id',
            'nama_barang'        => 'required|string',
            'jumlah'             => 'required|integer|min:1',
            'kondisi'            => 'required',
            'metode_pengiriman'  => 'required',
            'tanggal_pengiriman' => 'required|date|after_or_equal:today',
            'foto'               => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'id_kategori',
            'nama_barang',
            'jumlah',
            'kondisi',
            'metode_pengiriman',
            'tanggal_pengiriman'
        ]);

        $data['user_id'] = Auth::id();
        $data['status_donasi'] = 'pending';

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/donasi'), $filename);
            $data['foto'] = $filename;
        }

        DataDonasi::create($data);

        return redirect()->route('data_donasi.index')
            ->with('success', 'Data donasi berhasil ditambahkan');
    }

    // =====================================================
    // SHOW
    // =====================================================
    public function show($id)
    {
        $data_donasi = DataDonasi::with(['user', 'kategori'])
            ->findOrFail($id);

        return view('pages.data_donasi.show', compact('data_donasi'));
    }

    // =====================================================
    // EDIT
    // =====================================================
    public function edit($id)
    {
        $data_donasi = DataDonasi::findOrFail($id);
        $kategori = Kategori::all();

        return view('pages.data_donasi.edit', compact('data_donasi', 'kategori'));
    }

    // =====================================================
    // UPDATE
    // =====================================================
    public function update(Request $request, $id)
    {
        $data_donasi = DataDonasi::findOrFail($id);

        $request->validate([
            'nama_barang'        => 'required',
            'jumlah'             => 'required|integer|min:1',
            'kondisi'            => 'required',
            'metode_pengiriman'  => 'required',
            'tanggal_pengiriman' => 'required|date|after_or_equal:today',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'nama_barang',
            'jumlah',
            'kondisi',
            'metode_pengiriman',
            'tanggal_pengiriman'
        ]);

        if ($request->hasFile('foto')) {
            if ($data_donasi->foto && file_exists(public_path('uploads/donasi/' . $data_donasi->foto))) {
                unlink(public_path('uploads/donasi/' . $data_donasi->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/donasi'), $filename);
            $data['foto'] = $filename;
        }

        $data_donasi->update($data);

        return redirect()->route('data_donasi.index')
            ->with('success', 'Data berhasil diupdate');
    }

    // =====================================================
    // DELETE
    // =====================================================
    public function destroy($id)
    {
        $data_donasi = DataDonasi::findOrFail($id);

        if ($data_donasi->foto && file_exists(public_path('uploads/donasi/' . $data_donasi->foto))) {
            unlink(public_path('uploads/donasi/' . $data_donasi->foto));
        }

        if ($data_donasi->penyaluran()->count() > 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Donasi sudah digunakan pada data penyaluran.'
                );
        }

        $data_donasi->delete();

        return redirect()->route('data_donasi.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // =====================================================
    // STATUS ACTION
    // =====================================================
    public function proses($id)
    {
        DataDonasi::findOrFail($id)
            ->update(['status_donasi' => 'disetujui']);

        return back()->with('success', 'Donasi disetujui');
    }

    public function tolak($id)
    {
        DataDonasi::findOrFail($id)
            ->update(['status_donasi' => 'ditolak']);

        return back()->with('success', 'Donasi ditolak');
    }

}