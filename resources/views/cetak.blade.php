<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body { 
            padding: 20px;
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
        }
        .print-container {
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .header h3 {
            margin-bottom: 5px;
            color: #2c3e50;
            font-weight: bold;
        }
        .header p {
            color: #666;
            margin-bottom: 0;
        }
        .company-info {
            margin-bottom: 20px;
        }
        .company-info h4 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .company-info p {
            color: #666;
            margin-bottom: 2px;
        }
        .table {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #2c3e50;
            font-weight: 600;
        }
        .table tbody td {
            vertical-align: middle;
        }
        .table tfoot th {
            background-color: #f8f9fa;
            border-top: 2px solid #dee2e6;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: right;
            color: #666;
        }
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .detail-row {
            background-color: #f8f9fa;
        }
        .detail-row td {
            padding-left: 30px !important;
        }
        .detail-row td:first-child {
            padding-left: 50px !important;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .print-container {
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .table {
                border: 1px solid #000;
            }
            .table thead th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
            .table tfoot th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
            .detail-row {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container print-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h4>{{ config('app.name', 'Kasir App') }}</h4>
                <p>Jl. SembungJati No. 31</p>
                <p>Telp: 08979381884 | Email: kasirku.app@gmail.com</p>
            </div>
            <h3>Laporan Transaksi</h3>
            <p>Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}</p>
        </div>

        <!-- Content -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px">No</th>
                        <th>Tanggal</th>
                        <th>No Invoice</th>
                        <th>Detail Barang</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $t->kode }}</td>
                            <td>
                                @foreach($t->detailTransaksi as $detail)
                                    <div>
                                        {{ $detail->produk->name }} 
                                        ({{ $detail->jumlah }} x Rp {{ number_format($detail->produk->harga, 0, ',', '.') }})
                                    </div>
                                @endforeach
                            </td>
                            <td class="text-end">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total Pendapatan:</th>
                        <th class="text-end">Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>Dicetak oleh: {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Print Button -->
    <div class="print-button no-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg">
            <i class="fas fa-print"></i> Print Laporan
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>