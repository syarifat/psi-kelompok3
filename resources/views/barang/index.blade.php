@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Data Barang Kantin</h1>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Nama Barang</th>
                <th class="px-4 py-2 border">Harga</th>
                <th class="px-4 py-2 border">Kantin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
            <tr>
                <td class="px-4 py-2 border">{{ $barang->nama_barang }}</td>
                <td class="px-4 py-2 border">{{ number_format($barang->harga_barang, 2) }}</td>
                <td class="px-4 py-2 border">{{ $barang->kantin->nama_kantin ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
