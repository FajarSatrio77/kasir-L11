<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $peran;
    public $tipe_pelanggan;
    public $pilihanMenu = 'lihat';
    public $penggunaTerpilih;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // Hanya admin dan pemilik yang bisa mengakses manajemen pengguna
        if(!in_array(Auth::user()->peran, ['admin', 'pemilik'])){
            abort(403);
        }
    }

    public function updatedPeran($value)
    {
        if ($value !== 'pelanggan') {
            $this->tipe_pelanggan = null;
        }
    }

    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'peran', 'tipe_pelanggan']);
    }

    public function pilihEdit($id)
    {
        $this->pilihanMenu = 'edit';
        $this->penggunaTerpilih = UserModel::find($id);
        $this->name = $this->penggunaTerpilih->name;
        $this->email = $this->penggunaTerpilih->email;
        $this->peran = $this->penggunaTerpilih->peran;
        $this->tipe_pelanggan = $this->penggunaTerpilih->tipe_pelanggan;
    }

    public function pilihHapus($id)
    {
        $this->pilihanMenu = 'hapus';
        $this->penggunaTerpilih = UserModel::find($id);
    }

    public function simpan()
    {
        $rules = UserModel::rules();
        if ($this->peran === 'pelanggan') {
            $rules['tipe_pelanggan'] = 'required|in:1,2,3';
        }
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'peran' => $this->peran,
        ];

        if ($this->peran === 'pelanggan') {
            $data['tipe_pelanggan'] = $this->tipe_pelanggan;
        }

        UserModel::create($data);

        $this->pilihMenu('lihat');
        session()->flash('message', 'Pengguna berhasil ditambahkan.');
    }

    public function simpanEdit()
    {
        $rules = UserModel::rules(true);
        $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $this->penggunaTerpilih->id;
        if ($this->peran === 'pelanggan') {
            $rules['tipe_pelanggan'] = 'required|in:1,2,3';
        }
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'peran' => $this->peran,
        ];

        if ($this->peran === 'pelanggan') {
            $data['tipe_pelanggan'] = $this->tipe_pelanggan;
        } else {
            $data['tipe_pelanggan'] = null;
        }

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->penggunaTerpilih->update($data);

        $this->pilihMenu('lihat');
        session()->flash('message', 'Pengguna berhasil diperbarui.');
    }

    public function hapus()
    {
        $this->penggunaTerpilih->delete();
        $this->pilihMenu('lihat');
        session()->flash('message', 'Pengguna berhasil dihapus.');
    }

    public function batal()
    {
        $this->pilihMenu('lihat');
    }

    public function render()
    {
        return view('livewire.user', [
            'semuaPengguna' => UserModel::latest()->paginate(10)
        ]);
    }
}
