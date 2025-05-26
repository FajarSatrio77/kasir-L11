<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Beranda extends Component
{
    public function render()
    {
        // Data untuk hari ini
        $today = Carbon::today();
        
        // Total transaksi hari ini
        $totalTransaksiHariIni = Transaksi::where('status', 'selesai')
            ->whereDate('created_at', $today)
            ->count();
            
        // Total pendapatan hari ini
        $totalPendapatanHariIni = Transaksi::where('status', 'selesai')
            ->whereDate('created_at', $today)
            ->sum('total');
            
        // Produk dengan stok menipis (kurang dari 10)
        $totalStokMenipis = Produk::where('stok', '<', 10)->count();
        
        // Transaksi terakhir (5 transaksi)
        $transaksiTerakhir = Transaksi::where('status', 'selesai')
            ->latest()
            ->take(5)
            ->get();
            
        // Produk terlaris (5 produk)
        $produkTerlaris = Produk::select('produks.id', 'produks.name', DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'))
            ->join('detail_transaksis', 'produks.id', '=', 'detail_transaksis.produk_id')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->where('transaksis.status', 'selesai')
            ->groupBy('produks.id', 'produks.name')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        return view('livewire.beranda', [
            'totalTransaksiHariIni' => $totalTransaksiHariIni,
            'totalPendapatanHariIni' => $totalPendapatanHariIni,
            'totalStokMenipis' => $totalStokMenipis,
            'transaksiTerakhir' => $transaksiTerakhir,
            'produkTerlaris' => $produkTerlaris
        ]);
    }
}
