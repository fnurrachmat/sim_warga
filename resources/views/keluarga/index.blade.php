@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kartu Keluarga</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter Data</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('keluarga.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search">Nomor KK</label>
                            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Masukkan Nomor KK">
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="{{ route('keluarga.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>No KK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keluarga as $item)
                        <tr>
                            <td>{{ $item->no_kk }}</td>
                            <td>
                                <a href="{{ route('keluarga.detail', $item->no_kk) }}" class="btn btn-sm btn-info">Lihat Anggota</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
