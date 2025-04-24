@extends('layouts.app')

@section('title', 'Edit Warga')

@section('content')
    <h1>Edit Data Warga</h1>

    <form action="{{ route('warga.update', $warga->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $warga->nama) }}">
        </div>
        <div class="mb-3">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik', $warga->nik) }}">
        </div>
        <div class="mb-3">
            <label>No KK</label>
            <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $warga->no_kk) }}">
        </div>
        <div class="mb-3">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $warga->tempat_lahir ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}">
        </div>
        <div class="mb-3">
            <label>Agama</label>
            <select name="agama_id" class="form-control">
                <option value="">Pilih Agama</option>
                @foreach ($agamas as $agama)
                    <option value="{{ $agama->id }}" {{ old('agama_id', $warga->agama_id ?? '') == $agama->id ? 'selected' : '' }}>{{ $agama->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Pendidikan</label>
            <select name="pendidikan_id" class="form-control">
                <option value="">Pilih Pendidikan</option>
                @foreach ($pendidikans as $pendidikan)
                    <option value="{{ $pendidikan->id }}" {{ old('pendidikan_id', $warga->pendidikan_id ?? '') == $pendidikan->id ? 'selected' : '' }}>{{ $pendidikan->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Pekerjaan</label>
            <select name="pekerjaan_id" class="form-control">
                <option value="">Pilih Pekerjaan</option>
                @foreach ($pekerjaans as $pekerjaan)
                    <option value="{{ $pekerjaan->id }}" {{ old('pekerjaan_id', $warga->pekerjaan_id ?? '') == $pekerjaan->id ? 'selected' : '' }}>{{ $pekerjaan->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Status Perkawinan</label>
            <select name="status_id" class="form-control">
                <option value="">Pilih Status Perkawinan</option>
                @foreach ($statuss as $status)
                    <option value="{{ $status->id }}" {{ old('status_id', $warga->status_id ?? '') == $status->id ? 'selected' : '' }}>{{ $status->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Kewarganegaraan</label>
            <select name="kewarganegaraan_id" class="form-control">
                <option value="">Pilih Kewarganegaraan</option>
                @foreach ($kewarganegaraans as $kewarganegaraan)
                    <option value="{{ $kewarganegaraan->id }}" {{ old('kewarganegaraan_id', $warga->kewarganegaraan_id ?? '') == $kewarganegaraan->id ? 'selected' : '' }}>{{ $kewarganegaraan->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Status Dalam Keluarga</label>
            <select name="statusdalamkeluarga_id" class="form-control">
                <option value="">Pilih Status Dalam Keluarga</option>
                @foreach ($statusdalamkeluargas as $statusdalamkeluarga)
                    <option value="{{ $statusdalamkeluarga->id }}" {{ old('statusdalamkeluarga_id', $warga->statusdalamkeluarga_id ?? '') == $statusdalamkeluarga->id ? 'selected' : '' }}>{{ $statusdalamkeluarga->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Golongan Darah</label>
            <select name="golongandarah_id" class="form-control">
                <option value="">Pilih Golongan Darah</option>
                @foreach ($golongandarahs as $golongandarah)
                    <option value="{{ $golongandarah->id }}" {{ old('golongandarah_id', $warga->golongandarah_id ?? '') == $golongandarah->id ? 'selected' : '' }}>{{ $golongandarah->nama }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $warga->telepon ?? '') }}">
        </div>


        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('warga.index') }}" class="btn btn-secondary">Batal</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');

            form.addEventListener('submit', function (e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    field.classList.remove('is-invalid');
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                // Validasi NIK
                const nik = document.querySelector('[name="nik"]');
                if (nik && (!/^\d{16}$/.test(nik.value))) {
                    nik.classList.add('is-invalid');
                    isValid = false;
                    alert('NIK harus 16 digit angka.');
                }

                // Validasi No KK
                const noKK = document.querySelector('[name="no_kk"]');
                if (noKK && (!/^\d{16}$/.test(noKK.value))) {
                    noKK.classList.add('is-invalid');
                    isValid = false;
                    alert('No KK harus 16 digit angka.');
                }

                // Validasi Telepon
                const telepon = document.querySelector('[name="telepon"]');
                if (telepon && (!/^\d{10,15}$/.test(telepon.value))) {
                    telepon.classList.add('is-invalid');
                    isValid = false;
                    alert('Nomor telepon harus 10-15 digit angka.');
                }

                // Validasi Tanggal Lahir < Hari Ini
                const tanggalLahir = document.querySelector('[name="tanggal_lahir"]');
                if (tanggalLahir && new Date(tanggalLahir.value) >= new Date()) {
                    tanggalLahir.classList.add('is-invalid');
                    isValid = false;
                    alert('Tanggal lahir harus sebelum hari ini.');
                }

                if (!isValid) e.preventDefault();
            });
        });
    </script>
@endsection
