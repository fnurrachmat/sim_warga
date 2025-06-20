@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Keuangan Kas RT</h2>
        <a href="{{ route('keuangan.create') }}" class="btn btn-success">Tambah Transaksi</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Card Ringkasan -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pemasukan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-danger h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Pengeluaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Saldo Akhir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter Data</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('keuangan.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="jenis" class="form-label">Jenis Transaksi</label>
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">Semua</option>
                        <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Semua</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Reset</a>
                    <a href="{{ route('keuangan.export.pdf') }}" class="btn btn-danger">Export PDF</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keuangan as $k)
                            <tr>
                                <td>{{ $k->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $k->keterangan }}</td>
                                <td>{{ $k->kategori }}</td>
                                <td>
                                    @if($k->jenis == 'pemasukan')
                                        <span class="badge bg-success">Pemasukan</span>
                                    @else
                                        <span class="badge bg-danger">Pengeluaran</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($k->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if($k->bukti)
                                        <a href="{{ asset('storage/' . $k->bukti) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('keuangan.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('keuangan.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data keuangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection
