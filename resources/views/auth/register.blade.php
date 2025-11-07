<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8">
            <!-- Logo & Judul -->
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-12 mb-2">
                <span class="text-3xl font-bold text-cyan-700 text-center leading-tight">
                    KaSiPay
                </span>
                <div class="mt-2 text-lg font-semibold text-gray-700 text-center">
                    <span class="text-gray-700 text-2xl font-bold">Sistem Pembayaran Kantin</span>
                </div>
            </div>

            <!-- Register Header -->
            <div class="mb-6">
                <span class="text-2xl font-bold text-gray-700">Sign<span class="text-cyan-700">Up</span></span>
                <div class="text-sm text-gray-500 mt-1">Silakan isi data untuk membuat akun KaSiPay Anda.</div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <input type="text" id="name" name="name" placeholder="Full Name" :value="old('name')" required autofocus 
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-cyan-500 focus:border-cyan-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <input type="email" id="email" name="email" placeholder="Email Address" :value="old('email')" required
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-cyan-500 focus:border-cyan-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Password" required
                            class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-cyan-500 focus:border-cyan-500" />
                        <button type="button" onclick="togglePassword('password', 'eye1')" 
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400">
                            <svg id="eye1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required
                            class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-cyan-500 focus:border-cyan-500" />
                        <button type="button" onclick="togglePassword('password_confirmation', 'eye2')" 
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400">
                            <svg id="eye2" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('login') }}" class="text-sm text-cyan-600 hover:underline">
                        Already registered?
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-md bg-cyan-600 text-white font-bold shadow hover:bg-cyan-700 transition">
                        Register
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-xs text-gray-500 text-center">
                Copyright &copy; {{ date('Y') }} KaSiPay. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            if (input.type === 'password') {
                input.type = 'text';
                eye.style.opacity = 0.5;
            } else {
                input.type = 'password';
                eye.style.opacity = 1;
            }
        }
    </script>
</x-guest-layout>
