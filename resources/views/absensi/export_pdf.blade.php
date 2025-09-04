<!DOCTYPE html>
<html>
<head>
    <title>Export Absensi PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #888; padding: 6px; text-align: center; }
        th { background: #d1fae5; }
        tr:nth-child(even) { background: #f3f4f6; } /* abu-abu muda */
        tr:nth-child(odd) { background: #fff; }
    </style>
</head>
<body>
    <h2>Rekap Absensi Siswa</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIS</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $i => $row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->siswa->nama ?? '-' }}</td>
                <td>{{ $row->siswa->nis ?? '-' }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->jam }}</td>
                <td>{{ $row->status }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>