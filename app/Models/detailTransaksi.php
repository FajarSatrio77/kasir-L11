<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Transaksi;
use App\Models\Produk;

class detailTransaksi extends Model
{
    use HasFactory;
    protected $fillable = ['transaksi_id', 'produk_id', 'jumlah', 'harga'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

}
