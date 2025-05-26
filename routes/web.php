<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Produk;
use App\Livewire\Transaksi;
use App\Livewire\Laporan;
use App\Livewire\LaporanDetail;
use App\Livewire\Admin\CategoryManagement;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

route::get('/home', Beranda::class)->middleware(['auth'])->name('home');
route::get('/user', User::class)->middleware(['auth'])->name('user');
route::get('/produk', Produk::class)->middleware(['auth'])->name('produk');
route::get('/transaksi', Transaksi::class)->middleware(['auth'])->name('transaksi');
route::get('/laporan', Laporan::class)->middleware(['auth'])->name('laporan');
Route::get('/cetak', [App\Http\Controllers\CetakController::class, 'index'])->name('cetak');
Route::get('/admin/categories', CategoryManagement::class)->middleware(['auth'])->name('admin.categories');
Route::get('/laporan/{id}', LaporanDetail::class)->middleware(['auth'])->name('laporan.detail');
