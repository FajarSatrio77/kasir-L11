<div>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-primary">
                        <i class="fas fa-box"></i> Manajemen Produk
                    </h2>
                    <div>
                        <button wire:click="pilihMenu('tambah')" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
                <button wire:loading class="btn btn-info">
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-12">
                @if($pilihanMenu=='lihat')
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col">
                        <h5 class="mb-0">
                                    <i class="fas fa-list"></i> Daftar Produk
                        </h5>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" wire:model.live="filter_category_id">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px">No</th>
                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Tgl Kadaluarsa</th>
                                        <th>Tgl Pembelian</th>
                                        <th class="text-end">HPP</th>
                                        <th class="text-end">Harga Jual 1</th>
                                        <th class="text-end">Harga Jual 2</th>
                                        <th class="text-end">Harga Jual 3</th>
                                        <th class="text-center">Stok</th>
                                        <th class="text-center">Min Stok</th>
                                        <th class="text-center" style="width: 150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($semuaProduk as $produk)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $produk->kode }}</td>
                                            <td>{{ $produk->name }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $produk->category ? $produk->category->name : '-' }}
                                                </span>
                                            </td>
                                            <td>{{ $produk->expired_date ? \Carbon\Carbon::parse($produk->expired_date)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $produk->purchase_date ? \Carbon\Carbon::parse($produk->purchase_date)->format('d/m/Y') : '-' }}</td>
                                            <td class="text-end">Rp {{ number_format($produk->hpp, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($produk->harga_jual1, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($produk->harga_jual2, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($produk->harga_jual3, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $produk->stok <= $produk->minimal_stok ? 'bg-danger' : 'bg-success' }}">
                                                    {{ $produk->stok }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $produk->minimal_stok }}</td>
                                            <td class="text-center">
                                                <button wire:click="pilihEdit({{ $produk->id }})"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="pilihHapus({{ $produk->id }})"
                                                    class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center">Tidak ada data produk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @elseif ($pilihanMenu=='tambah')
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle"></i> Tambah Produk Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit="simpan" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-box"></i>
                                        </span>
                                        <input type="text" class="form-control" wire:model="name" placeholder="Masukkan nama produk">
                                    </div>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kode / Barcode</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                        <input type="text" class="form-control" wire:model="kode" placeholder="Masukkan kode produk">
                                    </div>
                                    @error('kode')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-tags"></i>
                                        </span>
                                        <select class="form-select" wire:model="category_id">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">HPP (Harga Pokok Produksi)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" wire:model="hpp" placeholder="Masukkan HPP">
                                    </div>
                                    @error('hpp')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stok</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-cubes"></i>
                                        </span>
                                        <input type="number" class="form-control" wire:model="stok" placeholder="Masukkan jumlah stok">
                                    </div>
                                    @error('stok')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Minimal Stok</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <input type="number" class="form-control" wire:model="minimal_stok" placeholder="Masukkan minimal stok">
                                    </div>
                                    @error('minimal_stok')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Kadaluarsa</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-times"></i>
                                        </span>
                                        <input type="date" class="form-control" wire:model="expired_date">
                                    </div>
                                    @error('expired_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Pembelian</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-plus"></i>
                                        </span>
                                        <input type="date" class="form-control" wire:model="purchase_date">
                                    </div>
                                    @error('purchase_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" wire:click='batal' class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @elseif ($pilihanMenu=='edit')
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit"></i> Edit Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit="simpanEdit" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-box"></i>
                                        </span>
                                        <input type="text" class="form-control" wire:model="name" placeholder="Masukkan nama produk">
                                    </div>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kode / Barcode</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                        <input type="text" class="form-control" wire:model="kode" placeholder="Masukkan kode produk">
                                    </div>
                                    @error('kode')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-tags"></i>
                                        </span>
                                        <select class="form-select" wire:model="category_id">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">HPP (Harga Pokok Produksi)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" wire:model="hpp" placeholder="Masukkan HPP">
                                    </div>
                                    @error('hpp')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stok</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-cubes"></i>
                                        </span>
                                        <input type="number" class="form-control" wire:model="stok" placeholder="Masukkan jumlah stok">
                                    </div>
                                    @error('stok')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Minimal Stok</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <input type="number" class="form-control" wire:model="minimal_stok" placeholder="Masukkan minimal stok">
                                    </div>
                                    @error('minimal_stok')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Kadaluarsa</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-times"></i>
                                        </span>
                                        <input type="date" class="form-control" wire:model="expired_date">
                                    </div>
                                    @error('expired_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Pembelian</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-plus"></i>
                                        </span>
                                        <input type="date" class="form-control" wire:model="purchase_date">
                                    </div>
                                    @error('purchase_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" wire:click='batal' class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @elseif ($pilihanMenu=='hapus')
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-trash"></i> Konfirmasi Hapus Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Anda yakin akan menghapus produk ini?
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Kode</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>HPP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $produkTerpilih->name }}</td>
                                        <td>{{ $produkTerpilih->kode }}</td>
                                        <td>{{ $produkTerpilih->category ? $produkTerpilih->category->name : '-' }}</td>
                                        <td>{{ $produkTerpilih->stok }}</td>
                                        <td>Rp {{ number_format($produkTerpilih->hpp, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button class="btn btn-secondary" wire:click='batal'>
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button class="btn btn-danger" wire:click='hapus'>
                                <i class="fas fa-trash"></i> Hapus Produk
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
