<?php

namespace App\Http\Controllers;

use App\Models\DataDonasi;
use App\Models\Kategori;
use App\Models\User;
use App\Models\DataPenyaluran;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DonaturController extends Controller
{
    // -------------------------------------------------------
    // DASHBOARD
    // -------------------------------------------------------

    public function dashboard()
    {
        $userId = Auth::id();

        return view('pages.donatur.dashboard', [
            'totalDonasi'   => DataDonasi::where('user_id', $userId)->count(),
            'pending'       => DataDonasi::where('user_id', $userId)->where('status_donasi', 'pending')->count(),
            'disetujui'     => DataDonasi::where('user_id', $userId)->where('status_donasi', 'disetujui')->count(),
            'selesai'       => DataDonasi::where('user_id', $userId)->where('status_donasi', 'selesai')->count(),
            'donasiTerbaru' => DataDonasi::where('user_id', $userId)->latest()->take(5)->get(),
        ]);
    }

    // -------------------------------------------------------
    // DONASI
    // -------------------------------------------------------

    public function donasiIndex()
    {
        $donasi = DataDonasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.donatur.riwayat_donasi', compact('donasi'));
    }

    public function riwayatDonasi()
    {
        $donasi = DataDonasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.donatur.riwayat_donasi', compact('donasi'));
    }

    public function donasiCreate()
    {
        $kategori = Kategori::all();
        $user = Auth::user(); 

        return view('pages.donatur.donasi.create', compact('kategori', 'user'));
    }

    public function donasiStore(Request $request)
    {
        $user = Auth::user();

        if (!$user->name || !$user->alamat || !$user->rt) {
            return redirect()->route('donatur.profil')
                ->with('error', 'Lengkapi profil terlebih dahulu sebelum donasi!');
        }
        
        $request->validate([
            'id_kategori'        => 'required|exists:kategoris,id',
            'nama_barang'        => 'required|string|max:255',
            'jumlah'             => 'required|integer|min:1',
            'kondisi'            => 'required|string',
            'metode_pengiriman'  => 'required|string',
            'tanggal_pengiriman' => 'required|date|after_or_equal:today',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'id_kategori', 'nama_barang', 'jumlah',
            'kondisi', 'metode_pengiriman', 'tanggal_pengiriman',
        ]);

        $data['user_id']       = Auth::id();
        $data['status_donasi'] = 'pending';

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        DataDonasi::create($data);

        return redirect()->route('donatur.donasi.index')
            ->with('success', 'Donasi berhasil dikirim! Menunggu persetujuan admin.');
    }

    public function donasiShow($id)
    {
        $item = DataDonasi::where('user_id', Auth::id())->findOrFail($id);
        return view('pages.donatur.donasi.show', compact('item'));
    }

    public function donasiEdit($id)
    {
        $item = DataDonasi::where('user_id', Auth::id())
                    ->where('status_donasi', 'pending')
                    ->findOrFail($id);

        $kategori = Kategori::all();

        return view('pages.donatur.donasi.edit', compact('item', 'kategori'));
    }

    public function donasiUpdate(Request $request, $id)
    {
        $item = DataDonasi::where('user_id', Auth::id())
                    ->where('status_donasi', 'pending')
                    ->findOrFail($id);

        $request->validate([
            'id_kategori'        => 'required|exists:kategoris,id',
            'nama_barang'        => 'required|string|max:255',
            'jumlah'             => 'required|integer|min:1',
            'kondisi'            => 'required|string',
            'metode_pengiriman'  => 'required|string',
            'tanggal_pengiriman' => 'required|date',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->metode_pengiriman == 'Dijemput pihak RW' && $request->jumlah < 10) {
            return back()->withErrors([
                'metode_pengiriman' => 'Penjemputan hanya bisa jika jumlah minimal 10 barang.'
            ])->withInput();
        }

        $data = $request->only([
            'id_kategori', 'nama_barang', 'jumlah',
            'kondisi', 'metode_pengiriman', 'tanggal_pengiriman',
        ]);

        if ($request->hasFile('foto')) {
            $this->hapusFoto($item->foto);
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        $item->update($data);

        return redirect()->route('donatur.donasi.index')
            ->with('success', 'Donasi berhasil diperbarui.');
    }

    public function donasiDestroy($id)
    {
        $item = DataDonasi::where('user_id', Auth::id())
                    ->where('status_donasi', 'pending')
                    ->findOrFail($id);

        $this->hapusFoto($item->foto);
        $item->delete();

        return redirect()->route('donatur.donasi.index')
            ->with('success', 'Donasi berhasil dihapus.');
    }

    // -------------------------------------------------------
    // PENYALURAN
    // -------------------------------------------------------

    public function penyaluran()
    {
        $data = DataPenyaluran::with(['donasi','penerima'])
            ->whereHas('donasi', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('pages.donatur.penyaluran', compact('data'));
    }

    // -------------------------------------------------------
    // PROFIL (FIX ERROR DI SINI)
    // -------------------------------------------------------

    public function profil()
    {
        $user = Auth::user(); // ✅ FIX: kirim user ke view
        return view('pages.donatur.profil', compact('user'));
    }

    public function profilUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,

            // ✅ VALIDASI NO TELP
            'no_telp'          => 'nullable|digits_between:12,15',

            'jenis_kelamin'    => 'nullable|in:L,P',
            'alamat'           => 'nullable|string|max:500',
            'rt'               => 'nullable|in:01,02,03,04,05,06',
            'current_password' => 'nullable|required_with:password',
            'password'         => 'nullable|min:6|confirmed',
        ], [
            // ✅ CUSTOM MESSAGE
            'no_telp.digits_between' => 'Nomor telepon harus 12 sampai 15 digit angka.',
            'email.unique'           => 'Email sudah digunakan.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
            'current_password.required_with' => 'Password lama wajib diisi jika ingin ganti password.',
        ]);

        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->no_telp       = $request->no_telp;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat        = $request->alamat;
        $user->rt            = $request->rt;

        // CEK PASSWORD
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Password lama tidak sesuai.',
                ]);
            }

            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // -------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------

    private function uploadFoto($file): string
    {
        $path = public_path('uploads/donasi');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($path, $filename);

        return $filename;
    }

    private function hapusFoto(?string $foto): void
    {
        if ($foto) {
            $fullPath = public_path('uploads/donasi/' . $foto);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}