<?php

namespace App\Http\Controllers;

use App\Models\DataPenerima;
use Illuminate\Http\Request;

class DataPenerimaController extends Controller
{
    public function index()
    {
        $data_penerima = DataPenerima::all();
        return view('pages.data_penerima.index', compact('data_penerima'));
    }

    public function create()
    {
        return view('pages.data_penerima.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        DataPenerima::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);
        
        return redirect()->route('data_penerima.index')->with('success', 'Data penerima berhasil ditambahkan');
    }

    public function show(DataPenerima $data_penerima)
    {
        return view('pages.data_penerima.show', compact('data_penerima'));
    }

    public function edit(DataPenerima $data_penerima)
    {
        return view('pages.data_penerima.edit', compact('data_penerima'));
    }

    public function update(Request $request, DataPenerima $data_penerima)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $data_penerima->update($request->all());
        return redirect()->route('data_penerima.index')->with('success', 'Data penerima berhasil diperbarui');
    }

    public function destroy(DataPenerima $data_penerima)
    {
        if ($data_penerima->penyaluran()->count() > 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data penerima sudah digunakan pada penyaluran.'
                );
        }

        $data_penerima->delete();

        return redirect()
            ->route('data_penerima.index')
            ->with(
                'success',
                'Data penerima berhasil dihapus'
            );
    }
}