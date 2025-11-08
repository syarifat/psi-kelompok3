<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KaSiPay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body x-data="{ sidebar: true }" class="bg-gray-50">

    {{-- NAVIGATION --}}
    @include('layouts.navigation_payment')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
