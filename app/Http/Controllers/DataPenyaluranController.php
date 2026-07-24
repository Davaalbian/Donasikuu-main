<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPenyaluran;
use App\Models\DataDonasi;
use App\Models\DataPenerima;

class DataPenyaluranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('m'));
        $tahun = $request->get('tahun', now()->format('Y'));

        $query = DataPenyaluran::with(
            'donasi',
            'penerima'
        );

        $query->whereMonth(
            'tanggal_penyaluran',
            $bulan
        );

        $query->whereYear(
            'tanggal_penyaluran',
            $tahun
        );

        $data_penyaluran = $query
            ->latest()
            ->get();

        return view('pages.data_penyaluran.index', compact(
            'data_penyaluran',
            'bulan',
            'tahun'
        ));
    }

    public function create()
    {
        $donasi = DataDonasi::where(
            'status_donasi',
            'disetujui'
        )->get();

        foreach ($donasi as $d) {

            $totalDisalurkan = DataPenyaluran::where(
                'id_donasi',
                $d->id
            )->sum('jumlah_disalurkan');

            $d->sisa = $d->jumlah - $totalDisalurkan;
        }

        $penerima = DataPenerima::all();

        return view(
            'pages.data_penyaluran.create',
            compact(
                'donasi',
                'penerima'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_donasi'             => 'required|exists:data_donasi,id',
            'id_penerima'           => 'required|exists:data_penerima,id',
            'jumlah_disalurkan'     => 'required|integer|min:1',
            'tanggal_penyaluran'    => 'required|date|after_or_equal:today',
            'lokasi'                => 'nullable|string|max:150',
            'status'                => 'required|in:pending,selesai',
            'keterangan'            => 'nullable|string',
            'bukti_foto'            => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $donasi = DataDonasi::findOrFail($request->id_donasi);

        $totalDisalurkan = DataPenyaluran::where(
            'id_donasi',
            $request->id_donasi
        )->sum('jumlah_disalurkan');

        $sisa = $donasi->jumlah - $totalDisalurkan;

        if ($request->jumlah_disalurkan > $sisa) {

            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_disalurkan' =>
                    'Jumlah melebihi sisa donasi. Sisa tersedia hanya '.$sisa
                ]);
        }
        
        $foto = null;

        // Upload Foto
        if ($request->hasFile('bukti_foto')) {
            $foto = time() . '.' . $request->bukti_foto->extension();
            $request->bukti_foto->move(
                public_path('uploads/penyaluran'),
                $foto
            );
        }

        // Simpan Penyaluran
        DataPenyaluran::create([
            'id_donasi' => $request->id_donasi,
            'id_penerima' => $request->id_penerima,
            'jumlah_disalurkan' => $request->jumlah_disalurkan,
            'tanggal_penyaluran' => $request->tanggal_penyaluran,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'bukti_foto' => $foto,
        ]);

        // Update Status Donasi
        $donasi = DataDonasi::find($request->id_donasi);

        $totalBaru = $totalDisalurkan + $request->jumlah_disalurkan;

        if ($totalBaru >= $donasi->jumlah) {

            $donasi->update([
                'status_donasi' => 'disalurkan'
            ]);

        } else {

            $donasi->update([
                'status_donasi' => 'disetujui'
            ]);

        }

        return redirect()
            ->route('data_penyaluran.index')
            ->with('success', 'Data penyaluran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = DataPenyaluran::findOrFail($id);

        $donasi = DataDonasi::where('status_donasi', 'disetujui')
            ->orWhere('id', $item->id_donasi)
            ->get();

        $penerima = DataPenerima::all();

        return view(
            'pages.data_penyaluran.edit',
            compact(
                'item',
                'donasi',
                'penerima'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_donasi'             => 'required|exists:data_donasi,id',
            'id_penerima'           => 'required|exists:data_penerima,id',
            'jumlah_disalurkan'     => 'required|integer|min:1',
            'tanggal_penyaluran'    => 'required|date',
            'lokasi'                => 'nullable|string|max:150',
            'status'                => 'required|in:pending,selesai',
            'keterangan'            => 'nullable|string',
            'bukti_foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $item = DataPenyaluran::findOrFail($id);

        $data = [
            'id_donasi'             => $request->id_donasi,
            'id_penerima'           => $request->id_penerima,
            'jumlah_disalurkan'     => $request->jumlah_disalurkan,
            'tanggal_penyaluran'    => $request->tanggal_penyaluran,
            'lokasi'                => $request->lokasi,
            'status'                => $request->status,
            'keterangan'            => $request->keterangan,
        ];

        // Update Foto Jika Ada
        if ($request->hasFile('bukti_foto')) {

            $foto = time() . '.' . $request->bukti_foto->extension();

            $request->bukti_foto->move(
                public_path('uploads/penyaluran'),
                $foto
            );

            $data['bukti_foto'] = $foto;
        }

        $item->update($data);

        // Sinkronisasi Status Donasi
        $donasi = DataDonasi::find($request->id_donasi);

        if ($donasi) {

            $totalDisalurkan = DataPenyaluran::where(
                'id_donasi',
                $request->id_donasi
            )->sum('jumlah_disalurkan');

            if ($totalDisalurkan >= $donasi->jumlah) {

                $donasi->update([
                    'status_donasi' => 'disalurkan'
                ]);

            } else {

                $donasi->update([
                    'status_donasi' => 'disetujui'
                ]);

            }
        }

        return redirect()
            ->route('data_penyaluran.index')
            ->with('success', 'Data penyaluran berhasil diupdate');
    }

    public function destroy($id)
    {
        $item = DataPenyaluran::findOrFail($id);

        $donasi = $item->donasi;

        $item->delete();

        if ($donasi) {

            $totalDisalurkan = DataPenyaluran::where(
                'id_donasi',
                $donasi->id
            )->sum('jumlah_disalurkan');

            if ($totalDisalurkan >= $donasi->jumlah) {

                $donasi->update([
                    'status_donasi' => 'disalurkan'
                ]);

            } else {

                $donasi->update([
                    'status_donasi' => 'disetujui'
                ]);

            }
        }

        return redirect()
            ->route('data_penyaluran.index')
            ->with('success', 'Data penyaluran berhasil dihapus');
    }
}