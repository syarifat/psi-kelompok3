<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SMP Islam Tulungagung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    /* Hilangkan icon bawaan select di semua browser */
    select#kelas_id {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none;
    }
    </style>
</head>
<body>
    @if(session('sidebar') === 'payment')
        @include('layouts.navigation_payment')
    @else
        @include('layouts.navigation_absensi')
    @endif
    @yield('scripts')
</body>
</html>