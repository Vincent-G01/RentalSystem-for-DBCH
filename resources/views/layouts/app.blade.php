<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- favicon icon --}}
    <link rel="icon" href="{{ URL::asset('DBCH.ico') }}" type="image/x-icon"/>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- CSS stylesheet --}}
    <link rel="stylesheet" href="{{ asset('resources/css/stylesheet.css') }}">
    <!-- Scripts --><!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Include FullCalendar CSS and JS -->
    {{-- <link href='{{ asset('fullcalendar/main.css') }}' rel='stylesheet' />
    <script src='{{ asset('fullcalendar/main.js') }}'></script> --}}

    
    
</head>
<body class="font-sans antialiased">
    <x-banner />
    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')
        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif
        <!-- Page Content -->
        <main>
            {{ $slot }} 
        </main>
    </div>
    @stack('modals')
    
    
    {{-- script --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @livewireScripts
    @livewireCalendarScripts
    
    
</body>
</html>