<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased min-h-screen flex flex-col">
<!-- Main Banner or Alerts -->
<x-banner />

<!-- Main Content Wrapper -->
<div class="flex-grow ">
    @livewire('navigation-menu')



   {{-- <!-- Page Heading (If Available) -->
    @if (isset($header))
        <header class="shadow bg-customBlack pt-4">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-customBlack">
                <h2 class="font-semibold text-xl text-customGreen leading-tight">
                    {{ $header }}
                </h2>
            </div>
        </header>

        <!-- Optional divider (under header) -->
        <div class="hidden sm:block">
            <div class="bg-customBlack">
                <div class="border-t border-white"></div>
            </div>
        </div>
    @endif--}}

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

</div>

<!-- Optional Modals or Additional Content -->
@stack('modals')

<!-- Livewire Scripts -->
@livewireScripts
</body>
</html>
