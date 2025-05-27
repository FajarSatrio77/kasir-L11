<div>
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-primary">
                        <i class="fas fa-boxes"></i> Laporan Stok
                    </h2>
                    <div>
                        <button class="btn btn-success" wire:click="printLaporan">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </button>
                        <button class="btn btn-info" wire:loading>
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Produk</h6>
                                <h3 class="mb-0">{{ $totalProduk }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-box fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Stok Menipis</h6>
                                <h3 class="mb-0">{{ $stokRendah }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Stok Habis</h6>
                                <h3 class="mb-0">{{ $stokHabis }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Nilai Stok</h6>
                                <h3 class="mb-0">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form wire:submit="filterStok">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" wire:model="tanggalMulai">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" wire:model="tanggalAkhir">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" wire:model="filter_category_id">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button type="button" class="btn btn-secondary" wire:click="resetFilter">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">Kode</th>
                                <th class="align-middle">Nama Produk</th>
                                <th class="align-middle">Kategori</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Stok</th>
                                <th class="text-center align-middle">Min Stok</th>
                                <th class="align-middle">Tgl Pembelian</th>
                                <th class="text-end align-middle">HPP</th>
                                <th class="text-end align-middle">Harga Jual 1</th>
                                <th class="text-end align-middle">Harga Jual 2</th>
                                <th class="text-end align-middle">Harga Jual 3</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produk as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->kode }}</td>
                                    <td class="align-middle">{{ $item->name }}</td>
                                    <td class="align-middle">{{ $item->category ? $item->category->name : '-' }}</td>
                                    <td class="text-center align-middle">
                                        @if($item->stok <= $item->minimal_stok)
                                            <span class="badge bg-danger">Stok Rendah</span>
                                        @else
                                            <span class="badge bg-success">Stok Aman</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $item->stok }}</td>
                                    <td class="text-center align-middle">{{ $item->minimal_stok }}</td>
                                    <td class="align-middle">{{ $item->purchase_date ? date('d/m/Y', strtotime($item->purchase_date)) : '-' }}</td>
                                    <td class="text-end align-middle">Rp {{ number_format($item->hpp, 0, ',', '.') }}</td>
                                    <td class="text-end align-middle">Rp {{ number_format($item->harga_jual1, 0, ',', '.') }}</td>
                                    <td class="text-end align-middle">Rp {{ number_format($item->harga_jual2, 0, ',', '.') }}</td>
                                    <td class="text-end align-middle">Rp {{ number_format($item->harga_jual3, 0, ',', '.') }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-4">Tidak ada data produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            white-space: nowrap;
        }
        .table td, .table th {
            padding: 0.75rem;
            vertical-align: middle;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.02);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.04);
        }
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }
        .table-responsive {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }
        .card-body {
            padding: 1.5rem;
        }
    </style>
</div> 