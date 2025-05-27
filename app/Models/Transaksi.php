<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\detailTransaksi;

class Transaksi extends Model
{
    protected $fillable = [
        'kode',
        'total',
        'status',
        'diskon_persen',
        'diskon_nominal',
        'subtotal',
        'ppn',
        'total_akhir',
        'poin_didapat',
        'poin_dipakai',
        'bayar',
        'kembalian'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
