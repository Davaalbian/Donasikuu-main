<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataDonasi;
use App\Models\DataPenyaluran;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPenyaluranExport;

class LaporanController extends Controller
{
    // ==========================
    // LAPORAN DONASI (FINAL ONLY)
    // ==========================
    public function donasi(Request $request)
    {
        $rt = $request->rt;

        $query = DataDonasi::with('user')
            ->whereIn('status_donasi', ['disalurkan', 'selesai']);

        if ($rt) {
            $query->whereHas('user', function ($q) use ($rt) {
                $q->where('rt', $rt);
            });
        }

        $data = $query->latest()->get();

        // COUNT RT (HANYA DATA FINAL)
        $rtCounts = DataDonasi::with('user')
            ->whereIn('status_donasi', ['disalurkan', 'selesai'])
            ->get()
            ->groupBy(fn($item) => $item->user->rt ?? '-')
            ->map(fn($group) => $group->count());

        return view('pages.laporan.donasi', compact('data', 'rtCounts', 'rt'));
    }

    // ==========================
    // PDF LAPORAN DONASI
    // ==========================
    public function donasiPdf(Request $request)
    {
        $rt = $request->rt;

        $query = DataDonasi::with('user')
            ->whereIn('status_donasi', ['disalurkan', 'selesai']);

        if ($rt) {
            $query->whereHas('user', function ($q) use ($rt) {
                $q->where('rt', $rt);
            });
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('pages.laporan.donasi_pdf', compact('data', 'rt'));

        return $pdf->stream('laporan_donasi.pdf');
    }

    // ==========================
    // EXPORT PENYALURAN (OPTIONAL)
    // ==========================
    public function penyaluran(Request $request)
    {
        $rt = $request->rt;

        $query = DataPenyaluran::with(['penerima', 'donasi'])
            ->where('status', 'selesai');

        $data = $query->latest()->get();

        return view('pages.laporan.penyaluran', compact('data', 'rt'));
    }

    // ==========================
    // PDF PENYALURAN
    // ==========================
    public function penyaluranPdf(Request $request)
    {
        $rt = $request->rt;

        $query = DataPenyaluran::with(['penerima', 'donasi'])
            ->where('status', 'selesai');

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('pages.laporan.penyaluran_pdf', compact('data'));

        return $pdf->stream('laporan_penyaluran.pdf');
    }

}