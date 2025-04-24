<!DOCTYPE html>
<html>
<head>
    <title>Data Warga</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 6px;
        }
    </style>
</head>
<body>
    <h2>Data Warga</h2>
    <table width="100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>No KK</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($warga as $w)
                <tr>
                    <td>{{ $w->nama }}</td>
                    <td>{{ $w->nik }}</td>
                    <td>{{ $w->no_kk }}</td>
                    <td>{{ $w->jenis_kelamin }}</td>
                    <td>{{ $w->tanggal_lahir }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
