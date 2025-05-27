<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Produk;
use App\Livewire\Transaksi;
use App\Livewire\Laporan;
use App\Livewire\LaporanDetail;
use App\Livewire\LaporanStok;
use App\Livewire\Admin\CategoryManagement;
use App\Http\Controllers\ActivityLogController;
use App\Livewire\Cetak;
use App\Livewire\AdminCategories;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

// Route yang bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', Beranda::class)->name('home');
    
    // Route untuk manajemen
    Route::get('/user', User::class)->name('user');
    Route::get('/produk', Produk::class)->name('produk');
    Route::get('/admin/categories', CategoryManagement::class)->name('admin.categories');
    
    // Route untuk transaksi
    Route::get('/transaksi', Transaksi::class)->name('transaksi');
    Route::get('/laporan', Laporan::class)->name('laporan');
    Route::get('/laporan/stok', LaporanStok::class)->name('laporan.stok');
    Route::get('/laporan/detail/{id}', LaporanDetail::class)->name('laporan.detail');
    
    // Route untuk cetak
    Route::get('/cetak/laporan', Cetak::class)->name('cetak.laporan');
    Route::get('/cetak/stok', [App\Http\Controllers\CetakController::class, 'stok'])->name('cetak.stok');

    // Route untuk activity logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});
