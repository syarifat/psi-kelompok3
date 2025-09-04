<div x-data="{ sidebar: true, profileOpen: false, whatsappOpen: false }" class="flex min-h-screen">
    <!-- Sidebar -->
    <aside
        x-show="sidebar"
        x-transition:enter="transition-all duration-300"
        x-transition:enter-start="opacity-0 -translate-x-10"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition-all duration-300"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-10"
        class="bg-white border-r border-gray-200 shadow-sm w-64 flex flex-col fixed inset-y-0 left-0 z-30"
        style="display: none;"
    >
        <!-- Logo & Judul -->
        <div class="flex items-center gap-2 px-6 py-4 border-b border-gray-100">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-10 w-10">
            </a>
            <span class="font-bold text-lg text-gray-700">Absensi SMP</span>
        </div>
        <!-- Navigation Links -->
        <nav class="flex-1 py-6 px-4 flex flex-col gap-2">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- Dashboard Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('absensi.index') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- Absensi Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Absensi
            </a>
            <a href="{{ route('kelas.index') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- Kelas Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Kelas
            </a>
            <a href="{{ route('siswa.index') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- Siswa Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                </svg>
                Siswa
            </a>
            <a href="{{ route('rombel_siswa.index') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- Rombel Siswa Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M3 20h5v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Rombel Siswa
            </a>
            <a href="{{ route('guru.index') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- Guru Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                </svg>
                Guru
            </a>
            <a href="{{ route('tahun_ajaran.index') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- Tahun Ajaran Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18" />
                </svg>
                Tahun Ajaran
            </a>
            <a href="{{ route('user.index') }}"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- User Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                </svg>
                User
            </a>
            <a href="#" @click.prevent="whatsappOpen = !whatsappOpen"
               class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 font-medium px-3 py-2 rounded transition group">
                <!-- WhatsApp Icon -->
                <svg class="h-5 w-5 text-black group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.72 11.06a6 6 0 10-8.48 8.48l.36.36a1 1 0 001.41 0l2.12-2.12a1 1 0 000-1.41l-.36-.36a1 1 0 01-.29-.7V16a1 1 0 01.29-.7l2.12-2.12a1 1 0 011.41 0l.36.36a1 1 0 000 1.41l-2.12 2.12a1 1 0 01-1.41 0l-.36-.36a6 6 0 008.48-8.48z" />
                </svg>
                WhatsApp
                <svg class="h-4 w-4 ml-auto text-gray-400 group-hover:text-orange-500 transition" fill="none" viewBox="0 0 20 20">
                    <path d="M5.5 8l4.5 4.5L14.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <div x-show="whatsappOpen" x-transition class="pl-8 flex flex-col gap-1">
                <a href="{{ route('whatsapp.index') }}"
                   class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 px-3 py-2 rounded transition">
                    <span class="text-xs">Broadcast</span>
                </a>
                <a href="{{ route('whatsapp.qr') }}"
                   class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 px-3 py-2 rounded transition">
                    <span class="text-xs">QR</span>
                </a>
                <a href="{{ route('whatsapp.report') }}"
                   class="flex items-center gap-2 text-gray-700 hover:text-orange-500 hover:bg-orange-100/60 px-3 py-2 rounded transition">
                    <span class="text-xs">Report</span>
                </a>
            </div>
        </nav>
        <!-- Profile Section -->
        <!-- <div class="px-6 py-4 border-t border-gray-100 flex items-center gap-2">
            <span class="bg-orange-500 text-white rounded-full h-8 w-8 flex items-center justify-center font-bold">
                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
            </span>
            <div>
                <div class="text-gray-700 font-medium">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
            </div>
        </div> -->
    </aside>
    <!-- Main Content -->
    <div :class="sidebar ? 'ml-64' : 'ml-0'"
         class="flex-1 flex flex-col transition-all duration-300 ease-in-out">
        <!-- Topbar -->
        <header class="flex items-center justify-between bg-white border-b border-gray-200 px-4 h-14">
            <!-- Sidebar Toggle Button -->
            <button @click="sidebar = !sidebar" class="text-gray-700 hover:bg-gray-100 rounded p-2">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <!-- Profile Dropdown -->
            <div class="relative">
                <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                    <span class="bg-orange-500 text-white rounded-full h-8 w-8 flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </span>
                    <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 20 20">
                        <path d="M5.5 8l4.5 4.5L14.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.away="profileOpen = false"
                     class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Log Out</button>
                    </form>
                </div>
            </div>
        </header>
        <!-- Page Content -->
        <main class="flex-1 bg-gray-50 p-4">
            @yield('content')
        </main>
    </div>
</div>
