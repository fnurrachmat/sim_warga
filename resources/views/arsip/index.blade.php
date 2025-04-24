@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Arsip Surat</h2>

    <a href="{{ route('arsip.create') }}" class="btn btn-success mb-3">Tambah Arsip Surat</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Warga</th>
                <th>Jenis Surat</th>
                <th>Keterangan</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arsipSurat as $arsip)
                <tr>
                    <td>{{ $arsip->warga->nama }}</td>
                    <td>{{ $arsip->jenis_surat }}</td>
                    <td>{{ $arsip->keterangan }}</td>
                    <td>{{ $arsip->created_at->format('d/m/Y') }}</td>
                    <td>
                        <!-- Tombol untuk cetak ulang (PDF) -->
                        <a href="{{ route('arsip.cetak-ulang', $arsip->id) }}" class="btn btn-warning btn-sm" target="_blank">Cetak Ulang</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
