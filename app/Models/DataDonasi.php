<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kategori;
use App\Models\DataPenyaluran;

class DataDonasi extends Model
{
    protected $table = 'data_donasi';

    protected $fillable = [
        'user_id',
        'id_kategori',
        'nama_barang',
        'jumlah',
        'kondisi',
        'metode_pengiriman',
        'tanggal_pengiriman',
        'foto',
        'status_donasi'
    ];

    /**
     * Relasi ke User (Donatur)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Relasi ke Penyaluran
     */
    public function penyaluran()
    {
        return $this->hasMany(DataPenyaluran::class, 'id_donasi');
    }
}