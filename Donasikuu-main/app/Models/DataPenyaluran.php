<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DataDonasi;
use App\Models\DataPenerima;

class DataPenyaluran extends Model
{
    protected $table = 'data_penyaluran';

    protected $fillable = [
        'id_donasi',
        'id_penerima',
        'jumlah_disalurkan',
        'tanggal_penyaluran',
        'lokasi',
        'bukti_foto',
        'status',
        'keterangan',
    ];
    
    protected $casts = [
        'tanggal_penyaluran' => 'date',
    ];

    public function donasi()
    {
        return $this->belongsTo(DataDonasi::class, 'id_donasi');
    }

    public function penerima()
    {
        return $this->belongsTo(DataPenerima::class, 'id_penerima');
    }

    public function getFotoUrlAttribute()
    {
        return $this->bukti_foto
            ? asset('uploads/penyaluran/' . $this->bukti_foto)
            : null;
    }
}