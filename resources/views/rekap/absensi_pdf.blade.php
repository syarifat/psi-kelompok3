<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; text-align: center; padding: 2px; }
        th { background: #0097a7; color: #fff; }
        .sunday { background: #f44336; color: #fff; }
        .libur { background: #9e9e9e; color: #fff; }
        .alpha { background: #ffcccc; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Rekap Absensi Siswa</h3>
    <p>
        Tahun Ajaran : {{ $tahun }} <br>
        Kelas        : {{ $kelas }} <br>
        Periode      : {{ $periode }}
    </p>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIS</th>
            @for($d=1;$d<=$daysInMonth;$d++)
                @php
                    $tgl = sprintf("%02d",$d);
                    $cell = $rekap[0]['data'][$d];
                    $cls = $cell['is_sunday'] ? 'sunday' : ($cell['is_libur'] ? 'libur' : '');
                @endphp
                <th class="{{ $cls }}">{{ $tgl }}</th>
            @endfor
            <th>H</th><th>S</th><th>I</th><th>A</th>
        </tr>

        @foreach($rekap as $i => $r)
        <tr>
            <td>{{ $i+1 }}</td>
            <td style="text-align:left">{{ $r['nama'] }}</td>
            <td>{{ $r['nis'] }}</td>
            @for($d=1;$d<=$daysInMonth;$d++)
                @php
                    $cell = $r['data'][$d];
                    $cls = $cell['is_sunday'] ? 'sunday' : ($cell['is_libur'] ? 'libur' : ($cell['status']=='A' ? 'alpha' : ''));
                @endphp
                <td class="{{ $cls }}">{{ $cell['status'] }}</td>
            @endfor
            <td>{{ $r['H'] }}</td>
            <td>{{ $r['S'] }}</td>
            <td>{{ $r['I'] }}</td>
            <td>{{ $r['A'] }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
