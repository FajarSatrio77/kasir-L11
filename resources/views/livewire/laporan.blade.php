<div>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-primary">
                        <i class="fas fa-chart-bar"></i> Laporan Transaksi
                    </h2>
                    <div>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#printModal" @if(!$transaksi->count()) disabled @endif>
                            <i class="fas fa-print"></i> Print Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit="filterTransaksi" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="date" class="form-control" wire:model="tanggalMulai">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Akhir</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="date" class="form-control" wire:model="tanggalAkhir">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <button type="button" wire:click="resetFilter" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Daftar Transaksi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px">No</th>
                                        <th>Tanggal</th>
                                        <th>No Invoice</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksi as $t)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $t->kode }}</td>
                                            <td class="text-end">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">Selesai</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('laporan.detail', $t->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-search"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada transaksi</td>
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

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-print"></i> Print Laporan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="printLaporan">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" wire:model="printTanggalMulai">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" wire:model="printTanggalAkhir">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" class="btn btn-success" wire:click="printLaporan" data-bs-dismiss="modal">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('printLaporan', () => {
            // Ambil data transaksi dari server
            let transaksi = @json($transaksi);
            let totalPendapatan = transaksi.reduce((sum, t) => sum + t.total, 0);
            
            // Format tanggal
            let tanggalMulai = new Date(@this.printTanggalMulai).toLocaleDateString('id-ID');
            let tanggalAkhir = new Date(@this.printTanggalAkhir).toLocaleDateString('id-ID');
            
            // Buat jendela print
            let printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Laporan Transaksi</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { 
                                padding: 20px;
                                font-family: Arial, sans-serif;
                            }
                            .header {
                                text-align: center;
                                margin-bottom: 30px;
                            }
                            .header h3 {
                                margin-bottom: 5px;
                            }
                            .header p {
                                color: #666;
                            }
                            table {
                                width: 100%;
                                margin-bottom: 20px;
                            }
                            th, td {
                                padding: 8px;
                            }
                            .text-end {
                                text-align: right;
                            }
                            .text-center {
                                text-align: center;
                            }
                            @media print {
                                .no-print { display: none; }
                                body { padding: 0; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">
                                <h3>Laporan Transaksi</h3>
                                <p>Periode: ${tanggalMulai} s/d ${tanggalAkhir}</p>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tanggal</th>
                                        <th>No Invoice</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${transaksi.map((t, index) => `
                                        <tr>
                                            <td class="text-center">${index + 1}</td>
                                            <td>${new Date(t.created_at).toLocaleString('id-ID')}</td>
                                            <td>${t.kode}</td>
                                            <td class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(t.total)}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total Pendapatan:</th>
                                        <th class="text-end">Rp ${new Intl.NumberFormat('id-ID').format(totalPendapatan)}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="text-end mt-4">
                                <p>Dicetak pada: ${new Date().toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        <div class="text-center mt-3 no-print">
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </body>
                </html>
            `);
            printWindow.document.close();
        });
    });
</script>
@endpush
