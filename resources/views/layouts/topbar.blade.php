<header class="flex items-center justify-between bg-white border-b border-gray-200 px-4 h-14">
    <!-- Sidebar Toggle Button -->
    <button @click="sidebar = !sidebar" class="text-gray-700 hover:bg-gray-100 rounded p-2">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Profile Dropdown -->
    <div class="relative" x-data="{ profileOpen: false }">
        <button @click="profileOpen = !profileOpen"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
            <span class="bg-orange-500 text-white rounded-full h-8 w-8 flex items-center justify-center font-bold">
                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
            </span>
            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 20 20">
                <path d="M5.5 8l4.5 4.5L14.5 8" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="profileOpen" 
             x-transition
             @click.outside="profileOpen = false"
             class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-50"
             style="display: none;">
            <a href="{{ route('profile.edit') }}" 
               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</header>
