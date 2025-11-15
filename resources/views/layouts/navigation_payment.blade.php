<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside x-show="sidebar" 
           x-transition:enter="transition-transform duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition-transform duration-300"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="bg-white border-r w-64 flex flex-col fixed inset-y-0 left-0 z-30 h-screen overflow-y-auto">
        <!-- Logo & Profile Section -->
        <div class="flex flex-col px-6 py-4 border-b space-y-4">
            <!-- Logo with toggle -->
            <div class="flex items-center justify-between">
                <span class="font-bold text-xl text-cyan-700">KaSiPay</span>
                <button @click="sidebar = false" class="p-2 rounded hover:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ profileOpen: false }">
                <button @click="profileOpen = !profileOpen" class="w-full flex items-center gap-2 p-2 rounded hover:bg-gray-100 transition">
                    <span class="bg-orange-500 text-white rounded-full h-8 w-8 flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </span>
                    <span class="text-gray-700 font-medium flex-1 text-left">{{ Auth::user()->name }}</span>
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Profile Dropdown Menu -->
                <div x-show="profileOpen" @click.outside="profileOpen = false"
                     x-transition
                     class="absolute left-0 right-0 mt-1 bg-white border rounded-md shadow-lg z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-4 px-4 flex flex-col gap-1">
            <span class="text-xs text-gray-500 font-semibold px-3 mt-2 mb-1">Menu</span>
            
            <!-- Master Data Dropdown - HANYA UNTUK ADMIN -->
            @if (Auth::user()->role === 'admin')
            <div x-data="{ masterOpen: false }" class="mt-2">
                <button @click="masterOpen = !masterOpen" 
                        class="flex items-center justify-between w-full px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Master Data
                    </div>
                    <svg class="h-4 w-4 transition-transform" 
                         :class="masterOpen ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <!-- Dropdown items with increased indent and styling -->
                <div x-show="masterOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-1 space-y-1">
                    <a href="{{ route('siswa.index') }}" 
                       class="flex items-center gap-2 pl-10 pr-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-md border-l-2 border-transparent hover:border-cyan-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Data Siswa
                    </a>
                    <a href="{{ route('saldo.index') }}" 
                       class="flex items-center gap-2 pl-10 pr-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-md border-l-2 border-transparent hover:border-cyan-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Saldo Siswa
                    </a>
                    <a href="{{ route('kantin.index') }}" 
                       class="flex items-center gap-2 pl-10 pr-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-md border-l-2 border-transparent hover:border-cyan-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Data Kantin
                    </a>
                    <a href="{{ route('barang.index') }}" 
                       class="flex items-center gap-2 pl-10 pr-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-md border-l-2 border-transparent hover:border-cyan-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        Data Barang
                    </a>
                    <a href="{{ route('user.index') }}" 
                       class="flex items-center gap-2 pl-10 pr-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-md border-l-2 border-transparent hover:border-cyan-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Data User
                    </a>
                </div>
            </div>
            @endif
            
            <a href="{{ route('dashboard.payment') }}" 
               class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- Top Up Saldo - HANYA UNTUK ADMIN -->
            @if (Auth::user()->role === 'admin')
            <a href="{{ route('pos.topup') }}" 
               class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Top Up Saldo
            </a>
            @endif

            <!-- Transaksi (POS) - HANYA UNTUK PEMILIK_KANTIN -->
            @if (Auth::user()->role === 'pemilik_kantin')
            <a href="{{ route('pos.transaksi') }}" 
               class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Transaksi (POS)
            </a>

            <!-- Data Barang - HANYA UNTUK PEMILIK_KANTIN -->
            <a href="{{ route('barang.index') }}" 
               class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Data Barang
            </a>
            @endif

            <!-- Reports Dropdown -->
            <div x-data="{ reportsOpen: false }" class="mt-2">
                <button @click="reportsOpen = !reportsOpen" 
                        class="flex items-center justify-between w-full px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Laporan
                    </div>
                    <svg class="h-4 w-4 transition-transform" 
                         :class="reportsOpen ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <div x-show="reportsOpen" 
                     x-transition
                     class="mt-1 space-y-1">
                    <a href="{{ route('laporan.income') }}" 
                       class="flex items-center gap-2 pl-10 pr-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-md border-l-2 border-transparent hover:border-orange-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pendapatan
                    </a>
                    <a href="{{ route('laporan.transaksi') }}" 
                       class="flex items-center gap-2 pl-10 pr-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-md border-l-2 border-transparent hover:border-orange-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Detail Transaksi
                    </a>
                </div>
            </div>

        </nav>
    </aside>

    <!-- Mini Sidebar Toggle (visible when sidebar is closed) -->
    <div x-show="!sidebar" 
         class="fixed top-0 left-0 p-4 z-30">
        <button @click="sidebar = true" 
                class="p-2 bg-white rounded-md shadow-lg hover:bg-gray-100 transition-all duration-300">
            <svg class="h-6 w-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Main Content -->
    <div :class="sidebar ? 'ml-64' : 'ml-0'" 
         class="flex-1 transition-all duration-300">
        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>
