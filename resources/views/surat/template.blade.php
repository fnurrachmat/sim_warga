<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.5;
        }
        .center {
            text-align: center;
        }
        .mt-3 {
            margin-top: 1.5em;
        }
        .mb-1 {
            margin-bottom: 0.5em;
        }
    </style>
</head>
<body>
    <div class="center">
        <h2>RT/RW 01/01 KELURAHAN KONOHA</h2>
        <h3><u>SURAT PENGANTAR</u></h3>
        <p>Nomor: 00{{ $surat->id }}/RT01/{{ \Carbon\Carbon::now()->format('m/Y') }}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini, Ketua RT 01 RW 01 Kelurahan KONOHA menyatakan bahwa:</p>

    <table>
        <tr><td class="mb-1">Nama</td><td>: {{ $surat->warga->nama }}</td></tr>
        <tr><td class="mb-1">NIK</td><td>: {{ $surat->warga->nik }}</td></tr>
        <tr><td class="mb-1">Tempat/Tgl Lahir</td><td>: {{ $surat->warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->warga->tanggal_lahir)->format('d-m-Y') }}</td></tr>
        <tr><td class="mb-1">Jenis Kelamin</td><td>: {{ $surat->warga->jenis_kelamin }}</td></tr>
        <tr><td class="mb-1">Alamat</td><td>: {{ $surat->warga->alamat }}</td></tr>
    </table>

    <p class="mt-3">Adalah benar warga kami dan surat ini dibuat untuk keperluan:</p>
    <p><strong>{{ $surat->keperluan ?? $surat->jenis_surat }}</strong></p>

    <p>Demikian surat ini dibuat agar dapat digunakan sebagaimana mestinya.</p>

    <div class="mt-3" style="text-align: right">
        <p>Jakarta, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        <p>Ketua RT 01</p>
        <br><br>
        <p><u>_____________________</u></p>
    </div>
</body>
</html>
