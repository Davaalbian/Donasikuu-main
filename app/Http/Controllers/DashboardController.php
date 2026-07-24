<?php

namespace App\Http\Controllers;

use App\Models\DataDonasi;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard', [
            'totalDonasi' => DataDonasi::count(),

            'pending' => DataDonasi::where(
                'status_donasi',
                'pending'
            )->count(),

            'disetujui' => DataDonasi::where(
                'status_donasi',
                'disetujui'
            )->count(),

            'ditolak' => DataDonasi::where(
                'status_donasi',
                'ditolak'
            )->count(),

            'disalurkan' => DataDonasi::where(
                'status_donasi',
                'disalurkan'
            )->count(),

            'donasiTerbaru' => DataDonasi::latest()
                ->take(5)
                ->get()
        ]);
    }
}