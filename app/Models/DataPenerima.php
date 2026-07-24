<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPenerima extends Model
{
    protected $table = 'data_penerima'; // ✅ sudah diperbaiki

    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
    ];

    // 🔗 Relasi ke penyaluran
    public function penyaluran()
    {
        return $this->hasMany(DataPenyaluran::class, 'id_penerima');
    }
}