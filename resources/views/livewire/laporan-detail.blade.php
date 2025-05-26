<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-receipt"></i> Transaction Details</h5>
                    <a href="{{ route('laporan') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div><b>Invoice Number</b><br>{{ $transaksi->kode }}</div>
                            <div class="mt-2"><b>Date</b><br>{{ $transaksi->created_at->format('d M Y H:i') }}</div>
                            <div class="mt-2"><b>Cashier</b><br>{{ $transaksi->user->email ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div><b>Status</b><br>
                                <span class="badge bg-success">{{ ucfirst($transaksi->status) }}</span>
                            </div>
                            <div class="mt-2"><b>Payment Method</b><br>Cash</div>
                            <div class="mt-2"><b>Total Amount</b><br><span class="fw-bold text-success">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span></div>
                        </div>
                    </div>
                    <div class="mb-2"><b>Items</b></div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($transaksi->detailTransaksi as $item)
                                    @php $subtotal = ($item->produk->harga ?? 0) * $item->jumlah; $total += $subtotal; @endphp
                                    <tr>
                                        <td>{{ $item->produk->name ?? '-' }}</td>
                                        <td>Rp {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Paid Amount:</th>
                                    <th>Rp {{ number_format($transaksi->bayar ?? 0, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Change:</th>
                                    <th>Rp {{ number_format($transaksi->kembalian ?? 0, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <a href="{{ route('laporan') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                    <button type="button" class="btn btn-info" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</div>
