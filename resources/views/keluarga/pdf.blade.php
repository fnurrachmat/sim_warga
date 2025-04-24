<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Keluarga - {{ $no_kk }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Kartu Keluarga</h2>
    <p>No KK: <strong>{{ $no_kk }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Status Keluarga</th>
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
</body>
</html>
