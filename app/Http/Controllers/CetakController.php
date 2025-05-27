<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
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

    public function stok(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $category_id = $request->category_id;

        $query = Produk::query()
            ->with('category')
            ->when($category_id, function($q) use ($category_id) {
                return $q->where('category_id', $category_id);
            })
            ->when($tanggalMulai, function($q) use ($tanggalMulai) {
                return $q->whereDate('created_at', '>=', $tanggalMulai);
            })
            ->when($tanggalAkhir, function($q) use ($tanggalAkhir) {
                return $q->whereDate('created_at', '<=', $tanggalAkhir);
            });

        $produk = $query->get();
        
        // Hitung statistik
        $totalProduk = $produk->count();
        $stokRendah = $produk->filter(function($item) {
            return $item->stok <= $item->minimal_stok && $item->stok > 0;
        })->count();
        $stokHabis = $produk->filter(function($item) {
            return $item->stok == 0;
        })->count();
        $totalNilaiStok = $produk->sum(function($item) {
            return $item->stok * $item->hpp;
        });

        return view('cetak.stok', [
            'produk' => $produk,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir,
            'totalProduk' => $totalProduk,
            'stokRendah' => $stokRendah,
            'stokHabis' => $stokHabis,
            'totalNilaiStok' => $totalNilaiStok
        ]);
    }
} 