@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Data Saldo Siswa</h1>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Nama Siswa</th>
                <th class="px-4 py-2 border">Saldo</th>
                <th class="px-4 py-2 border">Histori Topup</th>
            </tr>
        </thead>
        <tbody>
            @foreach($saldos as $saldo)
            <tr>
                <td class="px-4 py-2 border">{{ $saldo->siswa->nama ?? '-' }}</td>
                <td class="px-4 py-2 border">Rp. {{ number_format($saldo->saldo, 0, '', '.') }}</td>
                <td class="px-4 py-2 border">
                    <a href="{{ route('siswa.topup.histori', ['siswa_id' => $saldo->siswa->id]) }}" class="btn btn-info btn-sm">
                        Lihat Histori
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
