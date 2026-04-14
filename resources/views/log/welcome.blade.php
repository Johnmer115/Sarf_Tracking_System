<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SARP Tracking') }}</title>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Instrument Sans', sans-serif; background-color: white; }
        </style>
    @endif
</head>
<body class="bg-white text-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4">
        
        <div class="bg-white shadow-lg rounded-2xl p-10 max-w-2xl w-full text-center">
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Welcome to AU - SARP Tracking
            </h1>
            
            <p class="text-lg text-gray-600 mb-8">
                A comprehensive tracking system for managing and monitoring your operations.
            </p>
            
            <a 
                href="{{ route('login') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200"
            >
                Go to Login
            </a>

        </div>
    </div>
</body>
</html>
