@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Warga</h2>
        <a href="{{ route('warga.create') }}" class="btn btn-success">Tambah Warga</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter Data</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('warga.index') }}" method="GET" class="row mb-3 g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama warga..." value="{{ request('search') }}">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('warga.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-3">
        <a href="{{ route('warga.export.pdf') }}" class="btn btn-danger">Export PDF</a>
        <a href="{{ route('warga.export.excel') }}" class="btn btn-primary">Export Excel</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>No KK</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($warga as $w)
                            <tr>
                                <td>{{ $w->nama }}</td>
                                <td>{{ $w->nik }}</td>
                                <td>{{ $w->no_kk }}</td>
                                <td>{{ $w->tanggal_lahir }}</td>
                                <td>{{ $w->jenis_kelamin }}</td>
                                <td>
                                    <a href="{{ route('warga.edit', $w->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('warga.destroy', $w->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data warga.</td>
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
