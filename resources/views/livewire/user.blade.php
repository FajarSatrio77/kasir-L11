<div>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-primary">
                        <i class="fas fa-users"></i> Manajemen Pengguna
                    </h2>
                    <div>
                        <button wire:click="pilihMenu('tambah')" class="btn btn-success">
                            <i class="fas fa-user-plus"></i> Tambah Pengguna
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
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Daftar Pengguna
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Tipe Pengguna</th>
                                        <th>Hak Akses</th>
                                        <th>Poin</th>
                                        <th class="text-center" style="width: 200px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semuaPengguna as $pengguna)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $pengguna->name }}</td>
                                            <td>{{ $pengguna->email }}</td>
                                            <td>
                                                <span class="badge {{ $pengguna->peran == 'admin' ? 'bg-danger' : ($pengguna->peran == 'kasir' ? 'bg-success' : 'bg-info') }}">
                                                    {{ ucfirst($pengguna->peran) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($pengguna->peran == 'admin')
                                                    Full Access
                                                @elseif($pengguna->peran == 'kasir')
                                                    Transaksi & Laporan
                                                @elseif($pengguna->peran == 'pelanggan')
                                                    View Only
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($pengguna->peran == 'pelanggan')
                                                    {{ $pengguna->poin ?? 0 }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="pilihEdit({{ $pengguna->id }})"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button wire:click="pilihHapus({{ $pengguna->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $semuaPengguna->links() }}
                        </div>
                    </div>
                </div>
                @elseif ($pilihanMenu=='tambah')
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit="simpan" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" wire:model="name" placeholder="Masukkan nama lengkap">
                                    </div>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" wire:model="email" placeholder="Masukkan alamat email">
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" wire:model="password" placeholder="Minimal 8 karakter, 1 huruf besar, 1 huruf kecil, dan angka">
                                    </div>
                                    @error('password')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" wire:model="password_confirmation" placeholder="Ulangi password">
                                    </div>
                                    @error('password_confirmation')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Peran</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                        <select class="form-select" wire:model.live="peran">
                                            <option value="">Pilih Peran</option>
                                            <option value="admin">Admin</option>
                                            <option value="pemilik">Pemilik</option>
                                            <option value="kasir">Kasir</option>
                                            <option value="pelanggan">Pelanggan</option>
                                        </select>
                                    </div>
                                    @error('peran')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipe Pelanggan</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-users"></i>
                                        </span>
                                        <select class="form-select" wire:model="tipe_pelanggan" {{ $peran !== 'pelanggan' ? 'disabled' : '' }}>
                                            <option value="">Pilih Tipe</option>
                                            <option value="1">Tipe 1</option>
                                            <option value="2">Tipe 2</option>
                                            <option value="3">Tipe 3</option>
                                        </select>
                                    </div>
                                    @error('tipe_pelanggan')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" wire:click='batal' class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Pengguna
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @elseif ($pilihanMenu=='edit')
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-edit"></i> Edit Pengguna
                        </h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit="simpanEdit" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" wire:model="name" placeholder="Masukkan nama">
                                    </div>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" wire:model="email" placeholder="Masukkan email">
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" wire:model="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                    </div>
                                    @error('password')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Peran</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                        <select class="form-select" wire:model.live="peran">
                                            <option value="">Pilih Peran</option>
                                            <option value="admin">Admin</option>
                                            <option value="pemilik">Pemilik</option>
                                            <option value="kasir">Kasir</option>
                                            <option value="pelanggan">Pelanggan</option>
                                        </select>
                                    </div>
                                    @error('peran')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" wire:click='batal' class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @elseif ($pilihanMenu=='hapus')
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-trash"></i> Konfirmasi Hapus Pengguna
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Anda yakin akan menghapus pengguna ini?
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Peran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $penggunaTerpilih->name }}</td>
                                        <td>{{ $penggunaTerpilih->email }}</td>
                                        <td>
                                            <span class="badge {{ $penggunaTerpilih->peran == 'admin' ? 'bg-danger' : 'bg-success' }}">
                                                {{ ucfirst($penggunaTerpilih->peran) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button class="btn btn-secondary" wire:click='batal'>
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button class="btn btn-danger" wire:click='hapus'>
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
