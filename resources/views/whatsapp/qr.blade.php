@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <div class="bg-white shadow rounded-lg p-8 text-center">
        <h2 class="text-2xl font-bold mb-4 text-green-700">QR Connect WhatsApp Device</h2>
        @if($qr)
            <img src="data:image/png;base64,{{ $qr }}" alt="QR Code WhatsApp" class="mx-auto mb-4 w-64 h-64 rounded shadow">
            <div class="text-gray-700">Scan QR di aplikasi WhatsApp pada device Anda untuk menghubungkan.</div>
        @elseif($reason)
            <div class="text-red-600 font-bold">{{ $reason }}</div>
        @else
            <div class="text-red-600 font-bold">QR Code tidak tersedia.</div>
        @endif
    </div>
</div>
@endsection