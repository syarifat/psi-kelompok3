<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Set Password Guru</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
	<div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
		<h2 class="text-2xl font-bold text-center mb-6 text-orange-600">Set Password Guru</h2>
		@if(session('error'))
			<div class="mb-4 text-red-600 text-center">{{ session('error') }}</div>
		@endif
		<form method="POST" action="{{ route('set-password.store') }}">
			@csrf
			<div class="mb-4">
				<label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
				<input type="email" name="email" id="email" value="{{ old('email', $email ?? '') }}" required autofocus
					class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
				@error('email')
					<span class="text-red-600 text-sm">{{ $message }}</span>
				@enderror
			</div>
			<div class="mb-4">
				<label for="password" class="block text-gray-700 font-semibold mb-2">Password Baru</label>
				<input type="password" name="password" id="password" required
					class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
				@error('password')
					<span class="text-red-600 text-sm">{{ $message }}</span>
				@enderror
			</div>
			<div class="mb-6">
				<label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
				<input type="password" name="password_confirmation" id="password_confirmation" required
					class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
			</div>
			<button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg transition">Simpan Password</button>
		</form>
	</div>
</body>
</html>
