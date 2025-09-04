@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded">
        <strong>Perhatian:</strong> Fitur status pesan WhatsApp masih dalam pengembangan. Data status pesan mungkin belum real-time atau belum akurat.
    </div>
    <h2 class="text-2xl font-bold mb-4 text-green-700">Status Pesan WhatsApp</h2>
    <table class="min-w-full bg-white border border-green-300 rounded-lg shadow">
        <thead>
            <tr class="bg-green-400 text-white">
                <th class="px-4 py-2">ID Pesan</th>
                <th class="px-4 py-2">Nomor Tujuan</th>
                <th class="px-4 py-2">Pesan</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">State</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td class="px-4 py-2">{{ $report->message_id }}</td>
                <td class="px-4 py-2">{{ $report->target }}</td>
                <td class="px-4 py-2">{{ $report->message }}</td>
                <td class="px-4 py-2">{{ $report->status }}</td>
                <td class="px-4 py-2">{{ $report->state }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection