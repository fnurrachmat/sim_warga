@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Surat Pengantar</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('surat.create') }}" class="btn btn-success mb-3">+ Buat Surat Baru</a>

    <table class="table table-bordered">
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
@endsection
