<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $peran;
    public $tipe_pelanggan;
    public $pilihanMenu = 'lihat';
    public $penggunaTerpilih;
    public $semuaPengguna;

    public function mount()
    {
        if(Auth::user()->peran != 'admin'){
            abort(403);
        }
        $this->semuaPengguna = UserModel::all();
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
        $this->validate(UserModel::rules());

        UserModel::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'peran' => $this->peran,
            'tipe_pelanggan' => $this->peran === 'pelanggan' ? $this->tipe_pelanggan : null,
        ]);

        $this->pilihMenu('lihat');
        $this->semuaPengguna = UserModel::all();
        session()->flash('message', 'Pengguna berhasil ditambahkan.');
    }

    public function simpanEdit()
    {
        $rules = UserModel::rules(true);
        $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $this->penggunaTerpilih->id;
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'peran' => $this->peran,
            'tipe_pelanggan' => $this->peran === 'pelanggan' ? $this->tipe_pelanggan : null,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->penggunaTerpilih->update($data);

        $this->pilihMenu('lihat');
        $this->semuaPengguna = UserModel::all();
        session()->flash('message', 'Pengguna berhasil diperbarui.');
    }

    public function hapus()
    {
        $this->penggunaTerpilih->delete();
        $this->pilihMenu('lihat');
        $this->semuaPengguna = UserModel::all();
        session()->flash('message', 'Pengguna berhasil dihapus.');
    }

    public function batal()
    {
        $this->pilihMenu('lihat');
    }

    public function render()
    {
        return view('livewire.user');
    }
}
