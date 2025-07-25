<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body class="min-h-screen bg-white dark:bg-gray-50">

    {{-- Header separado --}}

 {{--    @include('layouts.app.header', ['title' => $title ?? null]) --}}
    <x-layouts.app.header :title="$title ?? null" />

    {{-- Contenido principal --}}
    <flux:main>
        {{ $slot }}
    </flux:main>

    {{-- Footer --}}
    <x-layouts.app.footer />

    @fluxScripts
</body>

</html>

{{-- <x-layouts.app.header :title="$title ?? null" />

<flux:main>
    {{ $slot }}
</flux:main>

<x-layouts.app.footer />
@fluxScripts --}}
