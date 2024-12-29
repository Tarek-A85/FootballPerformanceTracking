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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ar.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
   
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.team.team-navigation')

            @session('message')
<p class="text-xl text-white bg-gray-500 text-center py-4">{{ session('message') }}</p>
@endsession

@session('fail')
<p class="text-xl text-white bg-red-500 text-center py-4">{{ session('fail') }}</p>
@endsession

@session('success')
<p class="text-xl text-white bg-green-500 text-center py-4">{{ session('success') }}</p>
@endsession

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <script>
    flatpickr("#customDatePicker", {
        dateFormat: "d-m-Y", // Format: DD-MM-YYYY
        locale: "{{ app()->getLocale() }}"
    });
</script>
    </body>
</html>
