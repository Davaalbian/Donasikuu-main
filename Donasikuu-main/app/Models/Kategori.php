<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DataDonasi;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
    ];

    // relasi ke donasi
    public function donasi()
    {
        return $this->hasMany(DataDonasi::class, 'id_kategori');
    }
}