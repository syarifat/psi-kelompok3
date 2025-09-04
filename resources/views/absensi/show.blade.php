@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Detail Absensi</h2>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-2"><span class="font-semibold">Nama Siswa:</span> {{ $absensi->siswa->nama ?? '-' }}</div>
        <div class="mb-2"><span class="font-semibold">Tanggal:</span> {{ $absensi->tanggal }}</div>
        <div class="mb-2"><span class="font-semibold">Jam:</span> {{ $absensi->jam }}</div>
        <div class="mb-2"><span class="font-semibold">Status:</span> {{ ucfirst($absensi->status) }}</div>
        <div class="mb-2"><span class="font-semibold">Keterangan:</span> {{ $absensi->keterangan }}</div>
        <div class="mb-2"><span class="font-semibold">Input oleh User ID:</span> {{ $absensi->user_id }}</div>
    </div>
    <a href="{{ route('absensi.index') }}" class="mt-4 inline-block text-blue-600">&larr; Kembali ke Rekap</a>
</div>
@endsection
