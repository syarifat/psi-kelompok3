<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- file build statis untuk ngrok -->
        <link rel="stylesheet" href="/build/assets/app-RhMBbNUe.css">
        <script defer src="/build/assets/app-CQzja3Mz.js"></script>
    </head>
<body>
    {{ $slot }}
</body>
</html>
