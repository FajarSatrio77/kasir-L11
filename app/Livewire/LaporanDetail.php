<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;

class LaporanDetail extends Component
{
    public $transaksi;

    public function mount($id)
    {
        $this->transaksi = Transaksi::with(['detailTransaksi.produk', 'user'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.laporan-detail')->layout('layouts.print');
    }
}
