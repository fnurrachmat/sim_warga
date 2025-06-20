<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Kas RT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .summary {
            margin-top: 20px;
        }
        .summary table {
            width: 50%;
            margin-left: auto;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .page-break {
            page-break-after: always;
        }
        .green {
            color: green;
        }
        .red {
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KEUANGAN KAS RT</h2>
        <p>Periode: {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') : 'Awal' }} - {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') : 'Akhir' }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keuangan as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $k->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $k->keterangan }}</td>
                    <td>{{ $k->kategori }}</td>
                    <td class="text-right">
                        @if($k->jenis == 'pemasukan')
                            Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if($k->jenis == 'pengeluaran')
                            Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data keuangan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <th>Total Pemasukan</th>
                <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Pengeluaran</th>
                <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Saldo Akhir</th>
                <td class="text-right">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Ketua RT</p>
        <br><br><br>
        <p>(_________________________)</p>
        <p>Nama Jelas</p>
    </div>
</body>
</html>
