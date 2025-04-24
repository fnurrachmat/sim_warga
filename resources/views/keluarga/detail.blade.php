@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Anggota Keluarga - No KK: {{ $no_kk }}</h2>
    <a href="{{ route('keluarga.index') }}" class="btn btn-secondary mb-3">← Kembali</a>
    <a href="{{ route('keluarga.export.pdf', $no_kk) }}" target="_blank" class="btn btn-danger mb-3">
        📄 Export PDF
    </a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Status dalam Keluarga</th>
                <th>Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $a)
                <tr>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->nik }}</td>
                    <td>{{ $a->jenis_kelamin }}</td>
                    <td>{{ $a->status_dalam_keluarga }}</td>
                    <td>{{ $a->tanggal_lahir }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
