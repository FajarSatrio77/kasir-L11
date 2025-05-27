@extends('layouts.print')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-receipt"></i> Detail Transaksi</h5>
                    <a href="{{ route('laporan') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div><b>No. Invoice</b><br>{{ $transaksi->kode }}</div>
                            <div class="mt-2"><b>Tanggal</b><br>{{ $transaksi->created_at->format('d M Y H:i') }}</div>
                            <div class="mt-2"><b>Kasir</b><br>{{ $transaksi->user->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div><b>Status</b><br>
                                <span class="badge bg-success">{{ ucfirst($transaksi->status) }}</span>
                            </div>
                            <div class="mt-2"><b>Metode Pembayaran</b><br>Tunai</div>
                            <div class="mt-2"><b>Tipe Pelanggan</b><br>
                                @if($transaksi->user && $transaksi->user->tipe_pelanggan)
                                    Tipe {{ $transaksi->user->tipe_pelanggan }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-2"><b>Item</b></div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($transaksi->detailTransaksi as $item)
                                    @php $subtotal = ($item->harga ?? 0) * $item->jumlah; $total += $subtotal; @endphp
                                    <tr>
                                        <td>{{ $item->produk->name ?? '-' }}</td>
                                        <td>Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total Belanja:</th>
                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                </tr>
                                @if($transaksi->diskon_persen > 0)
                                <tr>
                                    <th colspan="3" class="text-end">Diskon ({{ number_format($transaksi->diskon_persen, 0) }}%):</th>
                                    <th class="text-danger">- Rp {{ number_format($transaksi->diskon_nominal, 0, ',', '.') }}</th>
                                </tr>
                                @endif
                                @if($transaksi->poin_dipakai > 0)
                                <tr>
                                    <th colspan="3" class="text-end">Poin Digunakan:</th>
                                    <th class="text-danger">- Rp {{ number_format($transaksi->poin_dipakai, 0, ',', '.') }}</th>
                                </tr>
                                @endif
                                <tr>
                                    <th colspan="3" class="text-end">Subtotal:</th>
                                    <th>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">PPN (12%):</th>
                                    <th>Rp {{ number_format($transaksi->ppn, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Total Akhir:</th>
                                    <th>Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Jumlah Bayar:</th>
                                    <th>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Kembalian:</th>
                                    <th>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</th>
                                </tr>
                                @if($transaksi->poin_didapat > 0)
                                <tr>
                                    <th colspan="3" class="text-end">Poin Didapat:</th>
                                    <th class="text-success">+ {{ number_format($transaksi->poin_didapat) }} poin</th>
                                </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-info" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
