<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use Carbon\Carbon;

class Cetak extends Component
{
    public $tanggalMulai;
    public $tanggalAkhir;
    public $transaksi;

    public function mount()
    {
        $this->tanggalMulai = request()->get('tanggal_mulai', Carbon::today()->format('Y-m-d'));
        $this->tanggalAkhir = request()->get('tanggal_akhir', Carbon::today()->format('Y-m-d'));
        $this->loadTransaksi();
    }

    public function loadTransaksi()
    {
        $this->transaksi = Transaksi::where('status', 'selesai')
            ->when($this->tanggalMulai, function($query) {
                return $query->whereDate('created_at', '>=', $this->tanggalMulai);
            })
            ->when($this->tanggalAkhir, function($query) {
                return $query->whereDate('created_at', '<=', $this->tanggalAkhir);
            })
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.cetak')->layout('layouts.print');
    }
} 