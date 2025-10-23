@include('layouts.topbar')

<div x-data="{ sidebar: true }" class="flex min-h-screen">
    <aside x-show="sidebar" class="bg-white border-r w-64 flex flex-col fixed inset-y-0 left-0 z-30 h-screen overflow-y-auto">
        <div class="sticky top-0 bg-white z-40 flex items-center gap-2 px-6 py-4 border-b">
            <a href="{{ route('dashboard.payment') }}">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-10 w-10">
            </a>
            <span class="font-bold text-lg text-gray-700">siPredi</span>
        </div>
        <nav class="flex-1 py-6 px-4 flex flex-col gap-2">
            <span class="text-xs text-gray-500 font-semibold px-3 mt-2 mb-1">Kantin Cashless</span>
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 text-gray-700 hover:text-blue-600 hover:bg-blue-100/60 font-medium px-3 py-2 rounded transition group w-full">
                    <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Master Data
                    <svg class="h-4 w-4 ml-auto text-gray-400" fill="none" viewBox="0 0 20 20">
                        <path d="M5.5 8l4.5 4.5L14.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-8 flex flex-col gap-1">
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">Siswa</a>
                    <a href="{{ route('rombel_siswa.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition">Rombel Siswa</a>
                    <a href="{{ route('saldo.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">Saldo Siswa</a>
                    <a href="{{ route('kantin.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">Kantin</a>
                    <a href="{{ route('barang.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">Barang</a>
                    <a href="{{ route('user.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">User</a>
                </div>
            </div>
            <a href="{{ route('dashboard.payment') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition group">Dashboard</a>
            <a href="{{ route('pos.topup') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition group">Top Up</a>
            <a href="{{ route('pos.transaksi') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition group">Transaksi (POS)</a>
            <a href="{{ route('pos.laporan') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition group">Laporan Transaksi</a>
        </nav>
    </aside>
    <div :class="sidebar ? 'ml-64' : 'ml-0'" class="flex-1 flex flex-col transition-all duration-300 ease-in-out">
        <main class="flex-1 bg-gray-50 p-4">
            @yield('content')
        </main>
    </div>
</div>