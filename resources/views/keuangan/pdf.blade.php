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
        .month-separator {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .month-total {
            background-color: #eaeaea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KEUANGAN KAS RT</h2>
        <p>Periode: {{ $daftarBulan[$bulan_awal] ?? 'Bulan '.$bulan_awal }} {{ $tahun_awal }} - {{ $daftarBulan[$bulan_akhir] ?? 'Bulan '.$bulan_akhir }} {{ $tahun_akhir }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    @php
        // Kelompokkan data berdasarkan bulan dan tahun
        $groupedData = [];
        $saldoAwalBulan = $saldoAwal ?? 0; // Gunakan saldo awal dari controller

        // Menentukan rentang bulan yang perlu ditampilkan
        $startDate = Carbon\Carbon::createFromDate($tahun_awal, $bulan_awal, 1);
        $endDate = Carbon\Carbon::createFromDate($tahun_akhir, $bulan_akhir, 1)->endOfMonth();
        $currentDate = clone $startDate;

        // Inisialisasi array untuk setiap bulan dalam rentang
        while ($currentDate <= $endDate) {
            $yearMonth = $currentDate->format('Y-m');
            $bulanKey = (int)$currentDate->format('m');
            $groupedData[$yearMonth] = [
                'data' => [],
                'totalPemasukan' => 0,
                'totalPengeluaran' => 0,
                'bulan' => $currentDate->format('m'),
                'tahun' => $currentDate->format('Y'),
                'namaBulan' => $daftarBulan[$bulanKey] ?? 'Bulan '.$bulanKey
            ];
            $currentDate->addMonth();
        }

        // Kelompokkan data transaksi ke bulan masing-masing
        foreach ($keuangan as $k) {
            $yearMonth = $k->tanggal->format('Y-m');
            if (isset($groupedData[$yearMonth])) {
                $groupedData[$yearMonth]['data'][] = $k;
                if ($k->jenis == 'pemasukan') {
                    $groupedData[$yearMonth]['totalPemasukan'] += $k->jumlah;
                } else {
                    $groupedData[$yearMonth]['totalPengeluaran'] += $k->jumlah;
                }
            }
        }
    @endphp

    @foreach ($groupedData as $yearMonth => $monthData)
        @if (!$loop->first)
            <div class="page-break"></div>
        @endif

        <h3>Laporan Bulan {{ $monthData['namaBulan'] }} {{ $monthData['tahun'] }}</h3>
        <p>Saldo Awal: Rp {{ number_format($saldoAwalBulan, 0, ',', '.') }}</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Kategori</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $runningBalance = $saldoAwalBulan;
                    $no = 1;
                @endphp

                @forelse($monthData['data'] as $k)
                    @php
                        if ($k->jenis == 'pemasukan') {
                            $runningBalance += $k->jumlah;
                        } else {
                            $runningBalance -= $k->jumlah;
                        }
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
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
                        <td class="text-right">Rp {{ number_format($runningBalance, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data keuangan</td>
                    </tr>
                @endforelse

                <tr class="month-total">
                    <td colspan="4" class="text-right"><strong>Total Bulan {{ $monthData['namaBulan'] }} {{ $monthData['tahun'] }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($monthData['totalPemasukan'], 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($monthData['totalPengeluaran'], 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($runningBalance, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        @php
            // Update saldo awal untuk bulan berikutnya
            $saldoAwalBulan = $runningBalance;
        @endphp
    @endforeach

    <div class="summary">
        <h3>Ringkasan Laporan</h3>
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
