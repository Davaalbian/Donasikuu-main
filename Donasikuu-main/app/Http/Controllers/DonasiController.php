<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataDonasi;

class DonasiController extends Controller
{
    // Menampilkan semua donasi user
    public function index()
    {
        $donatur = Auth::user();
        $donasis = DataDonasi::where('user_id', $donatur->id)
            ->latest()
            ->get();

        return view('donatur.donasi.index', compact('donasis'));
    }

    // Form tambah donasi
    public function create()
    {
        return view('donatur.donasi.create');
    }

    // Simpan donasi baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|integer',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'metode_pengiriman' => 'required|string',
            'tanggal_pengiriman' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'status_donasi' => 'nullable|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('donasi', 'public');
        }

        DataDonasi::create([
            'user_id' => Auth::id(),
            'id_kategori' => $request->id_kategori,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'metode_pengiriman' => $request->metode_pengiriman,
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'foto' => $fotoPath,
            'status_donasi' => $request->status_donasi ?? 'pending',
        ]);

        return redirect()->route('donatur.donasi.index')->with('success', 'Donasi berhasil ditambahkan!');
    }

    // Optional: tampilkan detail donasi
    public function show($id)
    {
        $donasi = DataDonasi::where('user_id', Auth::id())->findOrFail($id);
        return view('donatur.donasi.show', compact('donasi'));
    }

    // Optional: form edit donasi
    public function edit($id)
    {
        $donasi = DataDonasi::where('user_id', Auth::id())->findOrFail($id);
        return view('donatur.donasi.edit', compact('donasi'));
    }

    // Optional: update donasi
    public function update(Request $request, $id)
    {
        $donasi = DataDonasi::where('user_id', Auth::id())
            ->findOrFail($id);

        // =========================
        // VALIDASI
        // =========================
        $request->validate([
            'id_kategori' => 'required|integer',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'metode_pengiriman' => 'required|string',
            'tanggal_pengiriman' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        // =========================
        // RULE BISNIS:
        // kalau jumlah < 10 → AUTO paksa Antar Langsung
        // =========================
        $metode = $request->metode_pengiriman;

        if ($request->jumlah < 10) {
            $metode = 'Antar Langsung';
        }

        // tambahan keamanan (anti bypass)
        if ($request->jumlah < 10 && $request->metode_pengiriman == 'Dijemput pihak RW') {
            return back()
                ->withErrors([
                    'metode_pengiriman' => 'Barang di bawah 10 hanya bisa Antar Langsung.'
                ])
                ->withInput();
        }

        // =========================
        // FOTO HANDLING
        // =========================
        $fotoPath = $donasi->foto;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('donasi', 'public');
        }

        // =========================
        // UPDATE DATA
        // =========================
        $donasi->update([
            'id_kategori' => $request->id_kategori,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'metode_pengiriman' => $metode, // <-- FIX UTAMA
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'foto' => $fotoPath,
        ]);

        return redirect()
            ->route('donatur.donasi.index')
            ->with('success', 'Donasi berhasil diperbarui!');
    }

    // Optional: hapus donasi
    public function destroy($id)
    {
        $donasi = DataDonasi::where('user_id', Auth::id())->findOrFail($id);
        $donasi->delete();

        return redirect()->route('donatur.donasi.index')->with('success', 'Donasi berhasil dihapus!');
    }
}