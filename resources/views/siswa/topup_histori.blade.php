@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl py-8">
    <!-- Header -->
    <div class="bg-orange-500 px-6 py-5 rounded-t-lg flex justify-center items-center">
        <svg class="h-7 w-7 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
        </svg>
        <span class="text-2xl font-bold text-white leading-tight text-center">Histori Top Up</span>
    </div>
    <!-- Info Siswa -->
    <div class="px-6 py-4 bg-orange-50 border-b">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-white border border-orange-200 rounded-lg h-10 w-10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Nama Siswa</div>
                    <div class="font-semibold text-gray-700">{{ $siswa->nama }}</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white border border-orange-200 rounded-lg h-10 w-10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Nomor Induk</div>
                    <div class="font-semibold text-gray-700">{{ $siswa->nis }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="px-6 py-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-orange-100 rounded-lg">
                <thead>
                    <tr class="bg-orange-100">
                        <th class="px-4 py-3 text-orange-700 text-sm font-semibold text-center rounded-tl-lg">Nominal</th>
                        <th class="px-4 py-3 text-orange-700 text-sm font-semibold text-center rounded-tr-lg">Tanggal & Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topups as $topup)
                    <tr class="hover:bg-orange-50 transition">
                        <td class="text-center px-4 py-3 font-bold text-orange-700">
                            Rp{{ number_format($topup->nominal, 0, ',', '.') }}
                        </td>
                        <td class="text-center px-4 py-3 text-gray-700">
                            {{ \Carbon\Carbon::parse($topup->waktu ?? $topup->created_at)->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-8 text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="h-12 w-12 text-orange-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4"/>
                                </svg>
                                <div class="font-semibold">Belum ada histori topup</div>
                                <div class="text-xs">Riwayat topup akan muncul di sini</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 bg-white border border-orange-400 text-orange-600 px-5 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection