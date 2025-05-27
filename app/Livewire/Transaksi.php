<?php

namespace App\Livewire;

use App\Models\detailTransaksi;
use Livewire\Component;
use App\Models\Transaksi as ModelsTransaksi;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transaksi extends Component
{
    public $kode, $total, $kembalian, $totalSemuaBelanja, $status;
    public $bayar;  
    public $transaksiAktif;
    public $tipe_pelanggan = 1;
    public $semuaProduk = [];
    public $notifikasiStok = '';
    public $diskon_persen = 0;
    public $diskon_nominal = 0;
    public $subtotal = 0;
    public $ppn = 0;
    public $total_akhir = 0;
    public $poin_didapat = 0;
    public $poin_dipakai = 0;
    public $poin_tersedia = 0;
    public $gunakan_poin = false;

    public function mount()
    {
        if(!Auth::check()) {
            abort(403);
        }

        // Cek peran pengguna
        if(!in_array(Auth::user()->peran, ['admin', 'pemilik', 'kasir'])) {
            abort(403, 'Unauthorized action.');
        }

        // Set tipe_pelanggan berdasarkan peran
        if(Auth::user()->peran === 'pelanggan') {
            // Untuk pelanggan, gunakan tipe yang sudah ditentukan
            $this->tipe_pelanggan = Auth::user()->tipe_pelanggan ?? 1;
            $this->poin_tersedia = Auth::user()->poin ?? 0;
        } else {
            // Untuk admin dan kasir, default ke tipe 1
            $this->tipe_pelanggan = 1;
        }

        $this->semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id ?? null)->get();
    }

    public function updatedDiskonPersen($value)
    {
        $this->hitungTotal();
    }

    public function updatedGunakanPoin($value)
    {
        $this->hitungTotal();
    }

    protected function hitungTotal()
    {
        if($this->transaksiAktif){
            $this->semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
            $tipe = $this->tipe_pelanggan;
            
            // Hitung total belanja sebelum diskon
            $this->totalSemuaBelanja = $this->semuaProduk->sum(function ($detail) use ($tipe) {
                if ($tipe == 2) {
                    return $detail->produk->harga_jual2 * $detail->jumlah;
                } elseif ($tipe == 3) {
                    return $detail->produk->harga_jual3 * $detail->jumlah;
                } else {
                    return $detail->produk->harga_jual1 * $detail->jumlah;
                }
            });

            // Hitung diskon
            $this->diskon_nominal = ($this->totalSemuaBelanja * $this->diskon_persen) / 100;
            
            // Hitung subtotal (setelah diskon)
            $this->subtotal = $this->totalSemuaBelanja - $this->diskon_nominal;

            // Hitung poin yang didapat (2% dari total belanja sebelum diskon)
            if(in_array($this->tipe_pelanggan, ['1', '2'])) {
                $this->poin_didapat = floor($this->totalSemuaBelanja * 0.02);
            } else {
                $this->poin_didapat = 0;
            }

            // Hitung poin yang dipakai (jika menggunakan poin)
            if($this->gunakan_poin && $this->poin_tersedia > 0) {
                $this->poin_dipakai = min($this->poin_tersedia, floor($this->subtotal));
                $this->subtotal -= $this->poin_dipakai;
            } else {
                $this->poin_dipakai = 0;
            }

            // Hitung PPN (12% dari subtotal setelah diskon dan poin)
            $this->ppn = $this->subtotal * 0.12;

            // Hitung total akhir
            $this->total_akhir = $this->subtotal + $this->ppn;

            // Update transaksi
            $this->transaksiAktif->update([
                'diskon_persen' => $this->diskon_persen,
                'diskon_nominal' => $this->diskon_nominal,
                'subtotal' => $this->subtotal,
                'ppn' => $this->ppn,
                'total_akhir' => $this->total_akhir,
                'poin_didapat' => $this->poin_didapat,
                'poin_dipakai' => $this->poin_dipakai
            ]);
        }
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

    public function simpanTransaksi()
    {
        if($this->bayar < $this->total_akhir) {
            session()->flash('error', 'Pembayaran kurang!');
            return;
        }

        DB::transaction(function () {
            // Update status transaksi
            $this->transaksiAktif->update([
                'status' => 'selesai',
                'total' => $this->total_akhir
            ]);

            // Update poin user jika ada
            if($this->transaksiAktif->user_id) {
                $user = User::find($this->transaksiAktif->user_id);
                if($user) {
                    $user->poin += $this->poin_didapat - $this->poin_dipakai;
                    $user->save();
                }
            }
        });

        $this->transaksiBaru();
        session()->flash('message', 'Transaksi berhasil disimpan!');
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

    public function transaksiSelesai()
    {
        if($this->bayar < $this->total_akhir) {
            session()->flash('error', 'Pembayaran kurang!');
            return;
        }

        DB::transaction(function () {
            // Update status transaksi
            $this->transaksiAktif->update([
                'status' => 'selesai',
                'total' => $this->total_akhir,
                'bayar' => $this->bayar,
                'kembalian' => $this->bayar - $this->total_akhir
            ]);

            // Update poin user jika ada
            if($this->transaksiAktif->user_id) {
                $user = User::find($this->transaksiAktif->user_id);
                if($user) {
                    $user->poin += $this->poin_didapat - $this->poin_dipakai;
                    $user->save();
                }
            }
        });

        $this->transaksiBaru();
        session()->flash('message', 'Transaksi berhasil disimpan!');
    }

    public function updatedKode()
    {
        $produk = produk::where('kode', $this->kode)->first();
        if($produk) {
            if ($produk->stok <= 0) {
                $this->notifikasiStok = 'Stok barang habis.';
                return;
            }
            // Cek apakah produk sudah ada di detail transaksi
            $detail = DetailTransaksi::firstOrNew([
                'transaksi_id' => $this->transaksiAktif->id,
                'produk_id' => $produk->id
            ]);
            $jumlahBaru = $detail->exists ? $detail->jumlah + 1 : 1;
            if ($jumlahBaru > $produk->stok) {
                $this->notifikasiStok = 'Jumlah pembelian melebihi stok yang tersedia.';
                return;
            }
            $this->notifikasiStok = '';
            $tipe = $this->tipe_pelanggan;
            if ($tipe == 2) {
                $harga = $produk->harga_jual2;
            } elseif ($tipe == 3) {
                $harga = $produk->harga_jual3;
            } else {
                $harga = $produk->harga_jual1;
            }
            $detail->jumlah = $jumlahBaru;
            $detail->harga = $harga;
            $detail->save();
            $produk->stok -= 1;
            $produk->save();
            $this->reset('kode');
            $this->semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
            $this->dispatch('$refresh');
        }
    }

    public function updatedBayar()
    {
        if($this->bayar >= 0){
            $this->kembalian = $this->bayar - $this->total_akhir;
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
            $this->hitungTotal();
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
