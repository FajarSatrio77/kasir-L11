<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        .summary-item {
            padding: 10px;
            border-radius: 5px;
            background-color: white;
            border: 1px solid #ddd;
        }
        .summary-item h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
            color: #666;
        }
        .summary-item p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-danger {
            background-color: #dc3545;
            color: white;
        }
        .status-success {
            background-color: #198754;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .summary-grid {
                break-inside: avoid;
            }
            table {
                break-inside: auto;
            }
            tr {
                break-inside: avoid;
                break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KasirKu</h1>
        <h2>Laporan Stok</h2>
        <p>Jl. Sembung No. 31,</p>
        <p>Telp: 08979381884 | Email: kasirku.app@gmail.com</p>
        <p>Periode: {{ $tanggalMulai ? date('d/m/Y', strtotime($tanggalMulai)) : '-' }} s/d {{ $tanggalAkhir ? date('d/m/Y', strtotime($tanggalAkhir)) : '-' }}</p>
    </div>

    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <h4>Total Produk</h4>
                <p>{{ $totalProduk }}</p>
            </div>
            <div class="summary-item">
                <h4>Stok Menipis</h4>
                <p>{{ $stokRendah }}</p>
            </div>
            <div class="summary-item">
                <h4>Stok Habis</h4>
                <p>{{ $stokHabis }}</p>
            </div>
            <div class="summary-item">
                <h4>Total Nilai Stok</h4>
                <p>Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Stok</th>
                <th>Min Stok</th>
                <th>Tgl Pembelian</th>
                <th class="text-right">HPP</th>
                <th class="text-right">Harga Jual 1</th>
                <th class="text-right">Harga Jual 2</th>
                <th class="text-right">Harga Jual 3</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produk as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category ? $item->category->name : '-' }}</td>
                    <td class="text-center">
                        @if($item->stok <= $item->minimal_stok)
                            <span class="status-badge status-danger">Stok Rendah</span>
                        @else
                            <span class="status-badge status-success">Stok Aman</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->stok }}</td>
                    <td class="text-center">{{ $item->minimal_stok }}</td>
                    <td>{{ $item->purchase_date ? date('d/m/Y', strtotime($item->purchase_date)) : '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->hpp, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_jual1, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_jual2, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_jual3, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Tidak ada data produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>© {{ date('Y') }} KasirKu. All rights reserved.</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
</body>
</html> 