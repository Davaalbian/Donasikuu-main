<?php

namespace App\Exports;

use App\Models\DataPenyaluran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataPenyaluranExport implements FromCollection, WithHeadings
{
    protected $rt;

    public function __construct($rt = null)
    {
        $this->rt = $rt;
    }

    public function collection()
    {
        $query = DataPenyaluran::with(['penerima', 'donasi']);

        // FILTER RT
        if ($this->rt) {
            $query->whereHas('penerima', function ($q) {
                $q->where('rt', $this->rt);
            });
        }

        return $query->get()->map(function ($item) {
            return [
                'Tanggal'       => $item->created_at->format('Y-m-d'),
                'Nama Penerima' => $item->penerima->nama ?? '-',
                'RT'            => $item->penerima->rt ?? '-',
                'Jenis Donasi'  => $item->donasi->jenis ?? '-',
                'Jumlah'        => $item->jumlah,
                'Keterangan'    => $item->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Penerima',
            'RT',
            'Jenis Donasi',
            'Jumlah',
            'Keterangan',
        ];
    }
}