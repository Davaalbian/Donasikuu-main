<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Donasi extends Model
{
    protected $table = 'donasi'; // sesuaikan nama tabel kamu

    protected $fillable = [
        'id_kategori',
        'nama_barang',
        'jumlah',
        'kondisi',
        'metode_pengiriman',
        'tanggal_pengiriman',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}