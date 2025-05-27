<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanStok extends Component
{
    public $tanggalMulai;
    public $tanggalAkhir;
    public $printTanggalMulai;
    public $printTanggalAkhir;
    public $produk;
    public $filter_category_id;
    public $categories = [];
    public $totalProduk = 0;
    public $stokRendah = 0;
    public $stokHabis = 0;
    public $totalNilaiStok = 0;

    public function mount()
    {
        // Hanya admin, pemilik, dan kasir yang bisa mengakses laporan
        if(!in_array(Auth::user()->peran, ['admin', 'pemilik', 'kasir'])){
            abort(403);
        }

        $this->tanggalMulai = Carbon::today()->format('Y-m-d');
        $this->tanggalAkhir = Carbon::today()->format('Y-m-d');
        $this->categories = \App\Models\Category::orderBy('name')->get();
        $this->filterStok();
    }

    public function filterStok()
    {
        $query = Produk::query()
            ->when($this->filter_category_id, function($q) {
                return $q->where('category_id', $this->filter_category_id);
            })
            ->when($this->tanggalMulai, function($q) {
                return $q->whereDate('created_at', '>=', $this->tanggalMulai);
            })
            ->when($this->tanggalAkhir, function($q) {
                return $q->whereDate('created_at', '<=', $this->tanggalAkhir);
            });

        $this->produk = $query->get();
        
        // Hitung statistik
        $this->totalProduk = $this->produk->count();
        $this->stokRendah = $this->produk->filter(function($item) {
            return $item->stok <= $item->minimal_stok && $item->stok > 0;
        })->count();
        $this->stokHabis = $this->produk->where('stok', 0)->count();
        $this->totalNilaiStok = $this->produk->sum(function($item) {
            return $item->stok * $item->hpp;
        });
    }

    public function resetFilter()
    {
        $this->tanggalMulai = Carbon::today()->format('Y-m-d');
        $this->tanggalAkhir = Carbon::today()->format('Y-m-d');
        $this->filter_category_id = null;
        $this->filterStok();
    }

    public function printLaporan()
    {
        // Redirect ke halaman cetak dengan parameter tanggal
        return redirect()->route('cetak.stok', [
            'tanggal_mulai' => $this->tanggalMulai,
            'tanggal_akhir' => $this->tanggalAkhir,
            'category_id' => $this->filter_category_id
        ]);
    }

    public function render()
    {
        return view('livewire.laporan-stok');
    }
} 