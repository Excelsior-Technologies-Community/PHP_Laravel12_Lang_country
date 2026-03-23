<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel 12 - Lang & Country</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white">
            
            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center bg-white dark:bg-gray-800 rounded-lg shadow-xl">
                
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('messages.welcome') }} 
                </h1>

                <div class="mt-6 p-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        🌍 **Country:** <span class="font-bold text-blue-500">{{ request()->segment(1) }}</span>
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        🗣️ **Language:** <span class="font-bold text-green-500">{{ app()->getLocale() }}</span>
                    </p>
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ url('/IN/gu') }}" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">ગુજરાતી (IN)</a>
                    <a href="{{ url('/IN/hi') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">हिन्दी (IN)</a>
                    <a href="{{ url('/US/en') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">English (US)</a>
                </div>

            </div>
        </div>
    </body>
</html>