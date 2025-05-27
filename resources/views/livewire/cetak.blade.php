<div>
    <div class="container">
        <div class="text-center mb-4">
            <h2>Laporan Penjualan</h2>
            <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Diskon</th>
                        <th>PPN</th>
                        <th>Total Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $t->no_transaksi }}</td>
                            <td>{{ $t->user->name ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($t->diskon_nominal, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($t->ppn, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($t->total_akhir, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total:</th>
                        <th class="text-end">Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}</th>
                        <th class="text-end">Rp {{ number_format($transaksi->sum('diskon_nominal'), 0, ',', '.') }}</th>
                        <th class="text-end">Rp {{ number_format($transaksi->sum('ppn'), 0, ',', '.') }}</th>
                        <th class="text-end">Rp {{ number_format($transaksi->sum('total_akhir'), 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</div> 