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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="relevant w-full min-h-screen font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-600 to-orange-500"
          dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
          <div class="absolute top-4 right-4 p-6 text-white">
            <a href="{{ route('change_locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="hover:text-sky-500">
        <i class="fa-solid fa-globe"></i>
        {{ app()->getLocale() === 'ar' ? 'العربية' : 'en' }}
        </a>
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0  dark:bg-gray-900">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-blue-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-slate-300  shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
