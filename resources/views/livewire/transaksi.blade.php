<div>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-primary">
                        <i class="fas fa-cash-register"></i> Transaksi Kasir
                    </h2>
                    <div>
                        @if(!$this->transaksiAktif)
                            <button class="btn btn-primary" wire:click='transaksiBaru'>
                                <i class="fas fa-plus"></i> Transaksi Baru
                            </button>
                        @else
                            <button class="btn btn-danger" wire:click='batalTransaksi'>
                                <i class="fas fa-times"></i> Batalkan Transaksi
                            </button>
                        @endif
                        <button class="btn btn-info" wire:loading>
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if ($this->transaksiAktif)
            <div class="row">
                <div class="col-md-8">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt"></i> Invoice: {{ $transaksiAktif->kode }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Tipe Pelanggan</label>
                                <select class="form-select w-auto" wire:model="tipe_pelanggan">
                                    <option value="1">Tipe 1 (Harga Jual 1)</option>
                                    <option value="2">Tipe 2 (Harga Jual 2)</option>
                                    <option value="3">Tipe 3 (Harga Jual 3)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-barcode"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg" 
                                        placeholder="Scan barcode atau masukkan kode produk" 
                                        wire:model.live='kode'
                                        autofocus>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px">No</th>
                                            <th>Kode</th>
                                            <th>Nama Produk</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-center" style="width: 100px">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-center" style="width: 100px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_iterable($semuaProduk))
                                            @forelse ($semuaProduk as $produk)
                                                <tr wire:key="{{ $produk->id }}-{{ $tipe_pelanggan }}">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $produk->produk->kode }}</td>
                                                    <td>{{ $produk->produk->name }}</td>
                                                    <td class="text-end" wire:key="price-{{ $produk->id }}-{{ $tipe_pelanggan }}">
                                                        Rp {{ number_format(
                                                            ($tipe_pelanggan == 2) ? $produk->produk->harga_jual2 :
                                                            (($tipe_pelanggan == 3) ? $produk->produk->harga_jual3 : $produk->produk->harga_jual1),
                                                            0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center">{{ $produk->jumlah }}</td>
                                                    <td class="text-end" wire:key="subtotal-{{ $produk->id }}-{{ $tipe_pelanggan }}">
                                                        Rp {{ number_format(
                                                            (($tipe_pelanggan == 2) ? $produk->produk->harga_jual2 :
                                                            (($tipe_pelanggan == 3) ? $produk->produk->harga_jual3 : $produk->produk->harga_jual1)) * $produk->jumlah,
                                                            0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-danger" wire:click='hapusProduk({{ $produk->id }})'>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Belum ada produk</td>
                                                </tr>
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-calculator"></i> Total Pembayaran
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Total Belanja:</h6>
                                <h4 class="mb-0 text-primary">Rp {{ number_format($totalSemuaBelanja, 0, ',', '.') }}</h4>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Jumlah Bayar:</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control form-control-lg" 
                                        wire:model.live='bayar'
                                        placeholder="0">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Kembalian:</h6>
                                <h4 class="mb-0 {{ $kembalian < 0 ? 'text-danger' : 'text-success' }}">
                                    Rp {{ number_format($kembalian, 0, ',', '.') }}
                                </h4>
                            </div>

                            @if ($bayar)
                                @if($kembalian < 0)
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fas fa-exclamation-circle"></i> Uang pembayaran kurang!
                                    </div>
                                @elseif($kembalian >= 0)
                                    <button class="btn btn-success btn-lg w-100" wire:click='transaksiSelesai'>
                                        <i class="fas fa-check"></i> Selesaikan Pembayaran
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
