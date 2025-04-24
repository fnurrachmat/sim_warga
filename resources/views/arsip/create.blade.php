@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Arsip Surat</h2>

    <form action="{{ route('arsip.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="warga_id" class="form-label">Pilih Warga</label>
            <select name="warga_id" id="warga_id" class="form-control" required>
                <option value="">Pilih Warga</option>
                @foreach ($warga as $w)
                    <option value="{{ $w->id }}">{{ $w->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_surat" class="form-label">Jenis Surat</label>
            <input type="text" name="jenis_surat" id="jenis_surat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
