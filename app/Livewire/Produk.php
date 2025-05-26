<?php

namespace App\Livewire;

use App\Models\Produk as ModelProduk;
use App\Models\User as ModelUser;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Produk extends Component
{
    public $pilihanMenu = 'lihat';
    public $name;
    public $kode;
    public $harga;
    public $stok;
    public $produkTerpilih;
    public $category_id;
    public $filter_category_id;
    public $categories = [];
    public $expired_date, $purchase_date, $hpp, $harga_jual1, $harga_jual2, $harga_jual3, $minimal_stok;

    public function mount()
    {
        if(Auth::user()->peran != 'admin'){
            abort(403);
        }
        $this->categories = Category::orderBy('name')->get();
    }

public function pilihEdit($id)
{
    $this->produkTerpilih = ModelProduk::findOrFail($id);
    $this->name = $this->produkTerpilih->name;
    $this->kode = $this->produkTerpilih->kode;
    $this->stok = $this->produkTerpilih->stok;
    $this->harga = $this->produkTerpilih->harga;
    $this->category_id = $this->produkTerpilih->category_id;
    $this->expired_date = $this->produkTerpilih->expired_date;
    $this->purchase_date = $this->produkTerpilih->purchase_date;
    $this->hpp = $this->produkTerpilih->hpp;
    $this->harga_jual1 = $this->produkTerpilih->harga_jual1;
    $this->harga_jual2 = $this->produkTerpilih->harga_jual2;
    $this->harga_jual3 = $this->produkTerpilih->harga_jual3;
    $this->minimal_stok = $this->produkTerpilih->minimal_stok;
    $this->pilihanMenu = 'edit';
}

public function simpanEdit()
{
    $rules = [
        'name' => 'required',
        'kode' => 'required|unique:produks,kode,' . $this->produkTerpilih->id,
        'stok' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'expired_date' => 'required|date',
        'purchase_date' => 'required|date',
        'hpp' => 'required|numeric',
        'minimal_stok' => 'required|numeric',
    ];
    $this->validate($rules);
    $this->harga_jual1 = $this->hpp + round($this->hpp * 0.1);
    $this->harga_jual2 = $this->hpp + round($this->hpp * 0.2);
    $this->harga_jual3 = $this->hpp + round($this->hpp * 0.3);
    $this->produkTerpilih->update([
        'name' => $this->name,
        'kode' => $this->kode,
        'stok' => $this->stok,
        'category_id' => $this->category_id,
        'expired_date' => $this->expired_date,
        'purchase_date' => $this->purchase_date,
        'hpp' => $this->hpp,
        'harga_jual1' => $this->harga_jual1,
        'harga_jual2' => $this->harga_jual2,
        'harga_jual3' => $this->harga_jual3,
        'minimal_stok' => $this->minimal_stok,
    ]);
    session()->flash('message', 'Produk berhasil diupdate');
    $this->reset(['name', 'kode', 'stok', 'produkTerpilih', 'category_id', 'expired_date', 'purchase_date', 'hpp', 'harga_jual1', 'harga_jual2', 'harga_jual3', 'minimal_stok']);
    $this->pilihanMenu = 'lihat';
}

public function pilihMenu($menu)
{
        $this->pilihanMenu = $menu;
}

public function pilihHapus($id)
{
        $this->produkTerpilih = ModelProduk::findOrFail($id);
        $this->pilihanMenu = 'hapus';
}


public function hapus()
{
    $this->produkTerpilih->delete();
    $this->reset();
}

    public function batal()
    {
        $this->reset();
    }

    public function simpan()
    {
        $this->validate([
            'name' => 'required',
            'kode' => 'required|unique:produks',
            'stok' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'expired_date' => 'required|date',
            'purchase_date' => 'required|date',
            'hpp' => 'required|numeric',
            'minimal_stok' => 'required|numeric',
        ]);
        $this->harga_jual1 = $this->hpp + round($this->hpp * 0.1);
        $this->harga_jual2 = $this->hpp + round($this->hpp * 0.2);
        $this->harga_jual3 = $this->hpp + round($this->hpp * 0.3);
        ModelProduk::create([
            'name' => $this->name,
            'kode' => $this->kode,
            'stok' => $this->stok,
            'category_id' => $this->category_id,
            'expired_date' => $this->expired_date,
            'purchase_date' => $this->purchase_date,
            'hpp' => $this->hpp,
            'harga_jual1' => $this->harga_jual1,
            'harga_jual2' => $this->harga_jual2,
            'harga_jual3' => $this->harga_jual3,
            'minimal_stok' => $this->minimal_stok,
        ]);
        session()->flash('message', 'Produk berhasil ditambahkan');
        $this->reset(['name', 'kode', 'stok', 'category_id', 'expired_date', 'purchase_date', 'hpp', 'harga_jual1', 'harga_jual2', 'harga_jual3', 'minimal_stok']);
        $this->pilihanMenu = 'lihat';
    }
    public function render()
    {
        $query = ModelProduk::query();
        if ($this->filter_category_id) {
            $query->where('category_id', $this->filter_category_id);
        }
        return view('livewire.produk')->with([
            'semuaProduk' => $query->get(),
            'categories' => $this->categories,
            'filter_category_id' => $this->filter_category_id,
        ]);
    }
}
