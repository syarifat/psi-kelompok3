@include('layouts.topbar')

<div x-data="{ sidebar: true }" class="flex min-h-screen">
    <aside x-show="sidebar" class="bg-white border-r w-64 flex flex-col fixed inset-y-0 left-0 z-30 h-screen overflow-y-auto">
        <div class="sticky top-0 bg-white z-40 flex items-center gap-2 px-6 py-4 border-b">
            <a href="{{ route('dashboard.absensi') }}">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-10 w-10">
            </a>
            <span class="font-bold text-lg text-gray-700">siPredi</span>
        </div>
        <nav class="flex-1 py-6 px-4 flex flex-col gap-2">
            <span class="text-xs text-gray-500 font-semibold px-3 mt-2 mb-1">Absensi</span>
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group w-full">
                    <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Master Data
                    <svg class="h-4 w-4 ml-auto text-gray-400" fill="none" viewBox="0 0 20 20">
                        <path d="M5.5 8l4.5 4.5L14.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-8 flex flex-col gap-1">
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition">Siswa</a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition">Kelas</a>
                    <a href="{{ route('guru.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition">Guru</a>
                    <a href="{{ route('tahun_ajaran.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition">Tahun Ajaran</a>
                </div>
            </div>
            <a href="{{ route('dashboard.absensi') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition group">Dashboard</a>
            <a href="{{ route('absensi.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition group">Laporan Absensi</a>
            <a href="{{ route('rombel_siswa.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-500 px-3 py-2 rounded transition group">Rombel Siswa</a>
            <!-- Garis pemisah antara Kantin Cashless dan Setting -->
                    <div class="border-t border-gray-300 my-3"></div>
                    <!-- Grup Setting -->
                    <span class="text-xs text-gray-500 font-semibold px-3 mt-2 mb-1">Setting</span>
                    <a href="{{ route('user.index') }}"
                       class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                        <!-- User Icon -->
                        <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                        </svg>
                        User
                    </a>
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-2 text-gray-700 hover:text-green-600 hover:bg-green-100/60 font-medium px-3 py-2 rounded transition group w-full">
                            <!-- WhatsApp Icon -->
                            <svg class="h-5 w-5 text-black group-hover:text-green-600 transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.52 3.48A12 12 0 003.48 20.52a12 12 0 0017.04-17.04zm-8.52 17.04a9.52 9.52 0 119.52-9.52 9.52 9.52 0 01-9.52 9.52zm4.76-7.14c-.2-.1-1.18-.58-1.36-.64-.18-.06-.31-.1-.44.1-.13.2-.5.64-.62.78-.12.14-.23.16-.43.06-.2-.1-.84-.31-1.6-.99-.59-.52-.99-1.16-1.11-1.36-.12-.2-.01-.31.09-.41.09-.09.2-.23.3-.34.1-.11.13-.19.2-.32.07-.13.03-.25-.02-.35-.05-.1-.44-1.06-.6-1.45-.16-.39-.32-.34-.44-.35-.11-.01-.25-.01-.39-.01-.13 0-.34.05-.52.25-.18.2-.7.68-.7 1.66s.72 1.93.82 2.07c.1.14 1.41 2.16 3.42 2.95.48.17.85.27 1.14.34.48.1.92.09 1.27.06.39-.04 1.18-.48 1.35-.95.17-.47.17-.87.12-.95-.05-.08-.18-.13-.38-.23z"/>
                            </svg>
                            WhatsApp
                            <svg class="h-4 w-4 ml-auto text-gray-400 group-hover:text-green-600 transition" fill="none" viewBox="0 0 20 20">
                                <path d="M5.5 8l4.5 4.5L14.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="pl-8 flex flex-col gap-1">
                            <a href="{{ route('whatsapp.index') }}"
                               class="flex items-center gap-2 text-gray-700 hover:text-green-600 hover:bg-green-100/60 px-3 py-2 rounded transition">
                                <!-- Broadcast Icon -->
                                <svg class="h-4 w-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.5 10a7.5 7.5 0 1115 0 7.5 7.5 0 01-15 0zm7.5-5a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"/>
                                </svg>
                                <span class="text-base">Broadcast</span>
                            </a>
                            <a href="{{ route('whatsapp.qr') }}"
                               class="flex items-center gap-2 text-gray-700 hover:text-green-600 hover:bg-green-100/60 px-3 py-2 rounded transition">
                                <!-- QR Icon -->
                                <svg class="h-4 w-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                                    <rect x="3" y="3" width="4" height="4"/>
                                    <rect x="13" y="3" width="4" height="4"/>
                                    <rect x="3" y="13" width="4" height="4"/>
                                    <rect x="13" y="13" width="4" height="4"/>
                                </svg>
                                <span class="text-base">QR</span>
                            </a>
                            <a href="{{ route('whatsapp.report') }}"
                               class="flex items-center gap-2 text-gray-700 hover:text-green-600 hover:bg-green-100/60 px-3 py-2 rounded transition">
                                <!-- Report Icon -->
                                <svg class="h-4 w-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 3h14v2H3V3zm0 4h14v2H3V7zm0 4h14v2H3v-2zm0 4h14v2H3v-2z"/>
                                </svg>
                                <span class="text-base">Report</span>
                            </a>
                        </div>
                    </div>
        </nav>
    </aside>
    <div :class="sidebar ? 'ml-64' : 'ml-0'" class="flex-1 flex flex-col transition-all duration-300 ease-in-out">
        <main class="flex-1 bg-gray-50 p-4">
            @yield('content')
        </main>
    </div>
</div>