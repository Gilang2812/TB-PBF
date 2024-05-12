<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpus Gis') }} | {{ $title ?? ' ' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col bg-gray-100 fle">
        <header class=" bg-gradient-to-r from-slate-900 to-teal-950 text-white py-2">
            <div class="text-left mx-12 ">
                <h1
                    class="pb-2 bg-gradient-to-r from-zinc-50 to-white bg-clip-text text-transparent text-3xl font-bold text-stroke-2 text-left  border-b-2 stroke-zinc-50 webkit border-gray-800">
                    Sistem Pelayanan Perpustakaan LabGis</h1>
            </div>
        </header>
 
        <div class="grow flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
        
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        
        </div>
    </div>
</body>

</html>
