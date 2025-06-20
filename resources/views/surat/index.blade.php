@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Surat Pengantar</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('surat.create') }}" class="btn btn-success">+ Buat Surat Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>Nama Warga</th>
                        <th>NIK</th>
                        <th>Jenis Surat</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surat as $s)
                        <tr>
                            <td>{{ $s->warga->nama }}</td>
                            <td>{{ $s->warga->nik }}</td>
                            <td>{{ $s->jenis_surat }}</td>
                            <td>{{ $s->keperluan }}</td>
                            <td>{{ $s->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('surat.cetak', $s->id) }}" class="btn btn-sm btn-primary" target="_blank">Cetak PDF</a>
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
