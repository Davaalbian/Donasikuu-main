<?php

namespace App\Exports;

use App\Models\DataDonasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataDonasiExport implements FromCollection, WithHeadings
{
    protected $rt;

    // TERIMA PARAMETER RT
    public function __construct($rt = null)
    {
        $this->rt = $rt;
    }

    public function collection()
    {
        $query = DataDonasi::with('user')
            ->where('status_donasi', 'selesai');

        // FILTER BERDASARKAN RT
        if ($this->rt) {
            $query->whereHas('user', function ($q) {
                $q->where('rt', $this->rt);
            });
        }

        return $query->get()->map(function ($item) {
            return [
                'nama_donatur' => $item->user->name ?? '-',
                'no_telp'      => $item->user->no_telp ?? '-',
                'alamat'       => $item->user->alamat ?? '-',
                'nama_barang'  => $item->nama_barang,
                'jumlah'       => $item->jumlah,
                'kondisi'      => $item->kondisi,
                'metode'       => $item->metode_pengiriman,
                'tanggal'      => $item->tanggal_pengiriman,
                'status'       => ucfirst($item->status_donasi),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Donatur',
            'No Telepon',
            'Alamat',
            'Nama Barang',
            'Jumlah',
            'Kondisi',
            'Metode Pengiriman',
            'Tanggal',
            'Status',
        ];
    }
}