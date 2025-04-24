@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Buat Surat Pengantar</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('surat.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="warga_id" class="form-label">Nama Warga</label>
            <select name="warga_id" id="warga_id" class="form-control" required>
                <option value="">-- Pilih Warga --</option>
                @foreach ($warga as $w)
                    <option value="{{ $w->id }}">{{ $w->nama }} - {{ $w->nik }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_surat" class="form-label">Jenis Surat</label>
            <select name="jenis_surat" id="jenis_surat" class="form-control" required>
                <option value="">-- Pilih Jenis Surat --</option>
                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
                <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="keperluan" class="form-label">Keperluan (opsional)</label>
            <textarea name="keperluan" id="keperluan" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Buat Surat</button>
    </form>
</div>
@endsection
