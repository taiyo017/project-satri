<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $setting = \App\Models\Setting::first();
    $siteName = $setting->site_name ?? 'Satri Technologies';
    $pageTitle = isset($title) ? "$title | $siteName" : $siteName;
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-blue-500">
        @php
            $setting = \App\Models\Setting::first();
        @endphp
        <div class="flex items-center">
            <a href="/" class="inline-block group">
                @php
                    $logoExists = $setting?->logo_path && Storage::disk('public')->exists($setting->logo_path);
                    $logoUrl = $logoExists
                        ? asset('storage/' . $setting->logo_path)
                        : 'https://via.placeholder.com/150?text=Logo';
                @endphp

                <img src="{{ $logoUrl }}" alt="Site Logo"
                    class="w-20 h-20 object-contain transition-transform duration-200 group-hover:scale-105">
            </a>
        </div>


        <div class="w-full sm:max-w-md shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
