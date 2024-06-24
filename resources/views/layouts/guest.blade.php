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
    <link rel="shortcut icon" href="/logoGis.png" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" font-sans text-gray-900 h-screen overflow-hidden antialiased">
    @include('layouts.navigation')
    <div class="min-h-screen flex flex-col bg-gray-100 ">
 
        <div class="grow flex bg-gradient-to-l from-indigo-950 to-cyan-800 flex-col sm:justify-center items-center pt-6 sm:pt-0 ">           
                <div class="bg-gradient-to-r from-red-500 via-blue-500 to-purle-500 w-full shadow-lg shadow-violet-500 max-w-md rounded-xl border rotate-3">
                    <div class="w-full bg-white/60 backdrop-blur-sm border-2 border-white   flex justify-center rounded-lg -rotate-3">
                        <x-application-logo class="w-20 h-20 fill-curren bg-white rounded-full border text-gray-500" />                        
                    </div>
                </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-cyan-950 text-black border-white border-2 shadow-purple-500 shadow-lg overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        
        </div>
    </div>
</body>

</html>
