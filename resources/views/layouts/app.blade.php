<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Gestion Construction' }} - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
    @stack('styles')
    <style>
        .dataTables_empty { text-align: center !important; padding: 2rem 0 !important; color: #9ca3af; font-style: italic; }
        .dataTables_length select { min-width: 60px; padding: 2px 4px; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <div class="py-4">
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4" id="flash-message">
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm flex items-center justify-between" role="alert">
                        <span>{{ session('success') }}</span>
                        <button onclick="document.getElementById('flash-message').remove()" class="text-green-500 hover:text-green-700">&times;</button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4" id="flash-message">
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm flex items-center justify-between" role="alert">
                        <span>{{ session('error') }}</span>
                        <button onclick="document.getElementById('flash-message').remove()" class="text-red-500 hover:text-red-700">&times;</button>
                    </div>
                </div>
            @endif

            @if (isset($header))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $header }}</h1>
                </div>
            @endif

            <main>
                <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>
</html>
