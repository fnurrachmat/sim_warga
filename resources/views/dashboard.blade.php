@extends('layouts.app')

@section('title', 'Dashboard - Sistem Informasi Warga')

@section('content')
<div class="container-fluid px-0">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Statistik Utama -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Warga</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalWarga }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah KK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKK }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Surat Pengantar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSurat }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Laki-laki / Perempuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lakiLaki }} / {{ $perempuan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-venus-mars fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Status Pernikahan -->
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Menikah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $menikah }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ring fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Menikah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belumMenikah }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Aksi Cepat -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('warga.index') }}" class="btn btn-primary m-1">
                            <i class="fas fa-users me-1"></i> Kelola Data Warga
                        </a>
                        <a href="{{ route('keluarga.index') }}" class="btn btn-success m-1">
                            <i class="fas fa-home me-1"></i> Kelola Data Keluarga
                        </a>
                        <a href="{{ route('surat.index') }}" class="btn btn-warning m-1">
                            <i class="fas fa-envelope me-1"></i> Kelola Surat Pengantar
                        </a>
                        <a href="{{ route('keuangan.index') }}" class="btn btn-info m-1">
                            <i class="fas fa-money-bill me-1"></i> Kelola Keuangan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Keuangan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    @php
                        $namaBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $bulanAwalText = $namaBulan[$startDate->format('n')] ?? $startDate->format('F');
                        $bulanAkhirText = $namaBulan[$endDate->format('n')] ?? $endDate->format('F');
                    @endphp
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Keuangan ({{ $bulanAwalText }} {{ $startDate->format('Y') }} - {{ $bulanAkhirText }} {{ $endDate->format('Y') }})</h6>
                    <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-info h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Saldo Awal</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pemasukan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-arrow-down fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-danger h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pengeluaran</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-arrow-up fa-2x text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-primary h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Saldo Akhir</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($saldoKeuangan, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill-wave fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Terbaru -->
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Transaksi Terbaru</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Kategori</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transaksiTerbaru as $t)
                                        <tr>
                                            <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $t->keterangan }}</td>
                                            <td>{{ $t->kategori }}</td>
                                            <td>
                                                @if($t->jenis == 'pemasukan')
                                                    <span class="badge bg-success">Pemasukan</span>
                                                @else
                                                    <span class="badge bg-danger">Pengeluaran</span>
                                                @endif
                                            </td>
                                            <td class="text-end">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada transaksi</td>
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

    <!-- Grafik Kelompok Usia -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Kelompok Usia</h6>
                </div>
                <div class="card-body">
                    <canvas id="usiaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pendidikan & Pekerjaan -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pendidikan</h6>
                </div>
                <div class="card-body">
                    <canvas id="pendidikanChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pekerjaan</h6>
                </div>
                <div class="card-body">
                    <canvas id="pekerjaanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('usiaChart').getContext('2d');
    const usiaChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['0-17 (Anak)', '18-40 (Dewasa Muda)', '41-60 (Dewasa)', '60+ (Lansia)'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $usiaAnak }}, {{ $usiaDewasaMuda }}, {{ $usiaDewasa }}, {{ $usiaLansia }}],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const pendidikanData = {
        labels: {!! json_encode($pendidikan->pluck('nama_pendidikan')) !!},
        datasets: [{
            label: 'Pendidikan',
            data: {!! json_encode($pendidikan->pluck('total')) !!},
            backgroundColor: [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#20c997'
            ]
        }]
    };

    const pekerjaanData = {
        labels: {!! json_encode($pekerjaan->pluck('nama_pekerjaan')) !!},
        datasets: [{
            label: 'Pekerjaan',
            data: {!! json_encode($pekerjaan->pluck('total')) !!},
            backgroundColor: [
                '#f94144', '#f3722c', '#f9c74f', '#90be6d', '#43aa8b', '#577590'
            ]
        }]
    };

    new Chart(document.getElementById('pendidikanChart'), {
        type: 'doughnut',
        data: pendidikanData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    new Chart(document.getElementById('pekerjaanChart'), {
        type: 'doughnut',
        data: pekerjaanData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endpush
@endsection
