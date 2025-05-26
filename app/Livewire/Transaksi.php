<?php

namespace App\Livewire;

use App\Models\detailTransaksi;
use Livewire\Component;
use App\Models\Transaksi as ModelsTransaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class Transaksi extends Component
{
    public $kode, $total, $kembalian, $totalSemuaBelanja, $status;
    public $bayar;  
    public $transaksiAktif;
    public $tipe_pelanggan = 1;
    public $semuaProduk = [];

    public function mount()
    {
        if(Auth::user()->peran != 'admin'){
            // Jika bukan admin, set user_id transaksi dengan user login
            if(Auth::check()){
                 // Belum ada transaksi aktif saat mount, jadi ini akan dilakukan saat transaksiBaru
            } else {
                 abort(403);
            }
        }
        $this->semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id ?? null)->get();
    }

    public function transaksiBaru()
    {
        $this->reset();
        $this->transaksiAktif = new ModelsTransaksi();
        $this->transaksiAktif->kode = 'INV/' . date('YmdHis');
        $this->transaksiAktif->total = 0;
        $this->transaksiAktif->status = 'pending';

        // Set user_id transaksi saat transaksi baru dibuat
        if(Auth::check()){
            $this->transaksiAktif->user_id = Auth::user()->id;
        }

        $this->transaksiAktif->save();

        // Setelah transaksi baru dibuat, refresh daftar produk
        $this->semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
    }

    public function hapusProduk($id)
    {
        $detail = DetailTransaksi::find($id);
        if($detail){
            $produk = produk::find($detail->produk_id);
            $produk->stok += $detail->jumlah;
            $produk->save();
        }
        $detail->delete();
    }

    public function transaksiSelesai()
    {
        $this->transaksiAktif->total = $this->totalSemuaBelanja;
        $this->transaksiAktif->status = 'selesai';
        $this->transaksiAktif->bayar = $this->bayar;
        $this->transaksiAktif->kembalian = $this->kembalian;
        $this->transaksiAktif->save();
        $this->reset();
    }

    public function batalTransaksi(){
        if ($this->transaksiAktif) {
            $detailTransaksi = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
            foreach ($detailTransaksi as $detail) {
                $produk = produk::find($detail->produk_id);
                $produk->stok += $detail->jumlah;
                $produk->save();
                $detail->delete();
            }
            $this->transaksiAktif->delete();
        }
        $this->reset();
    }

    public function updatedKode()
    {
        $produk = produk::where('kode', $this->kode)->first();
        if($produk && $produk->stok > 0){
            $detail = DetailTransaksi::firstOrNew([
                'transaksi_id' => $this->transaksiAktif->id,
                'produk_id' => $produk->id
            ],[
                'jumlah' => 0
            ]);
            $detail->jumlah += 1;
            $detail->save();
            $produk->stok -= 1;
            $produk->save();
            $this->reset('kode');

            // Perbarui daftar produk setelah menambahkan item
            $this->semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();

            // Paksa Livewire untuk me-render ulang komponen
            $this->dispatch('$refresh');
        }
    }

    public function updatedBayar()
    {
        if($this->bayar >= 0){
            $this->kembalian = $this->bayar - $this->totalSemuaBelanja;
        }
    }

    // Method ini akan dipanggil otomatis saat tipe_pelanggan berubah
    public function updatedTipePelanggan()
    {
        // Hanya perlu memicu render ulang. Livewire akan memanggil render() kembali.
    }

    public function render()
    {
        // Ambil data produk transaksi jika ada transaksi aktif, jika tidak, kosongkan
        if($this->transaksiAktif){
            $this->semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
            $tipe = $this->tipe_pelanggan;
            $this->totalSemuaBelanja = $this->semuaProduk->sum(function ($detail) use ($tipe) {
                if ($tipe == 2) {
                    return $detail->produk->harga_jual2 * $detail->jumlah;
                } elseif ($tipe == 3) {
                    return $detail->produk->harga_jual3 * $detail->jumlah;
                } else {
                    return $detail->produk->harga_jual1 * $detail->jumlah;
                }
            });
        } else {
            $this->semuaProduk = collect(); // Gunakan koleksi kosong jika tidak ada transaksi aktif
            $this->totalSemuaBelanja = 0;
        }

        return view('livewire.transaksi')->with([
            'semuaProduk' => $this->semuaProduk,
            'tipe_pelanggan' => $this->tipe_pelanggan, // Pastikan tipe_pelanggan juga diteruskan
        ]);
    }
}
