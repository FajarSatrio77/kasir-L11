<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_akhir = $request->tanggal_akhir;

        $transaksi = Transaksi::where('status', 'selesai')
            ->when($tanggal_mulai, function($query) use ($tanggal_mulai) {
                return $query->whereDate('created_at', '>=', $tanggal_mulai);
            })
            ->when($tanggal_akhir, function($query) use ($tanggal_akhir) {
                return $query->whereDate('created_at', '<=', $tanggal_akhir);
            })
            ->latest()
            ->get();

        return view('cetak', compact('transaksi', 'tanggal_mulai', 'tanggal_akhir'));
    }
} 