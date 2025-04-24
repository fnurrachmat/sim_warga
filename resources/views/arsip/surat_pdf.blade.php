<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1, h2, h3 {
            text-align: center;
        }
        .content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Surat Pengantar</h1>
    <h2>Nomor: {{ $arsip->id }}</h2>

    <div class="content">
        <p><strong>Nama Warga:</strong> {{ $warga->nama }}</p>
        <p><strong>Jenis Surat:</strong> {{ $arsip->jenis_surat }}</p>
        <p><strong>Keterangan:</strong> {{ $arsip->keterangan }}</p>
        <p><strong>Tanggal Pengajuan:</strong> {{ $arsip->created_at->format('d/m/Y') }}</p>

        <!-- Tambahkan konten surat lainnya sesuai kebutuhan -->
    </div>

    <div class="footer" style="text-align: center; margin-top: 50px;">
        <p>Desa XYZ, {{ $arsip->created_at->format('d/m/Y') }}</p>
    </div>
</body>
</html>
