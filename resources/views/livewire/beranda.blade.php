<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </h2>
            </div>
        </div>

        <div class="row">
            <!-- Card Total Transaksi Hari Ini -->
            <div class="col-md-4 mb-4">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Transaksi Hari Ini</h6>
                                <h3 class="mb-0">{{ $totalTransaksiHariIni ?? 0 }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Total Pendapatan Hari Ini -->
            <div class="col-md-4 mb-4">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Pendapatan Hari Ini</h6>
                                <h3 class="mb-0">Rp {{ number_format($totalPendapatanHariIni ?? 0, 0, ',', '.') }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Produk Stok Menipis -->
            <div class="col-md-4 mb-4">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Stok Menipis</h6>
                                <h3 class="mb-0">{{ $totalStokMenipis ?? 0 }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Tabel Transaksi Terakhir -->
            <div class="col-md-8 mb-4">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-history"></i> Transaksi Terakhir
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>No Invoice</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksiTerakhir ?? [] as $transaksi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $transaksi->kode }}</td>
                                            <td class="text-end">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada transaksi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Produk Terlaris -->
            <div class="col-md-4 mb-4">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-star"></i> Produk Terlaris
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th class="text-center">Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produkTerlaris ?? [] as $produk)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $produk->name }}</td>
                                            <td class="text-center">{{ $produk->total_terjual }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
