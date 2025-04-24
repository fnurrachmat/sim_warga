@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kartu Keluarga</h2>
    <table class="table table-bordered">
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
@endsection
