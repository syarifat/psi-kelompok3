@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10">
    <div class="bg-white shadow rounded-lg p-8 text-center mb-6">
        <h2 class="text-2xl font-bold mb-2">Dashboard Payment</h2>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-bold mb-4">Daftar Transaksi</h3>
        <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td class="px-4 py-2 border">{{ $payment['id'] }}</td>
                    <td class="px-4 py-2 border">{{ $payment['nama'] }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($payment['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
