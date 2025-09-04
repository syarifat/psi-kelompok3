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