<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\detailTransaksi;

class Transaksi extends Model
{
    protected $fillable = ['kode','total', 'status'];
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
