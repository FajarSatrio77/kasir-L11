<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'name', 'kode', 'harga', 'stok', 'kategori_id',
        'expired_date', 'purchase_date', 'hpp',
        'harga_jual1', 'harga_jual2', 'harga_jual3', 'minimal_stok'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
