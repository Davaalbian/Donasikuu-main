<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    protected $fillable = [
        'id_donasi',
        'nama_penerima',
        'tanggal_penyaluran'
    ];

    // RELASI KE DONASI
    public function donasi()
    {
        return $this->belongsTo(DataDonasi::class, 'id_donasi');
    }
}