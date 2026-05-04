<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel 12 - Lang & Country</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-100 via-white to-pink-100 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">

<div class="min-h-screen flex items-center justify-center px-4">

    <!-- CARD -->
    <div class="w-full max-w-2xl backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 shadow-2xl rounded-3xl p-10 border border-white/20">

        <!-- TITLE -->
        <h1 class="text-4xl font-extrabold text-center text-gray-800 dark:text-white mb-8">
            🌍 {{ __('messages.welcome') }}
        </h1>

        <!-- INFO BOX -->
        <div class="grid grid-cols-2 gap-6 text-center">

            <div class="p-6 rounded-2xl bg-white/60 dark:bg-gray-900/40 shadow-md hover:scale-105 transition">
                <p class="text-sm text-gray-500">Country</p>
                <p class="text-3xl font-bold text-blue-600">
                    {{ request()->segment(1) }}
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white/60 dark:bg-gray-900/40 shadow-md hover:scale-105 transition">
                <p class="text-sm text-gray-500">Language</p>
                <p class="text-3xl font-bold text-green-600">
                    {{ app()->getLocale() }}
                </p>
            </div>

        </div>

        <!-- DIVIDER -->
        <div class="my-8 border-t border-gray-300 dark:border-gray-600"></div>

        <!-- SWITCH TITLE -->
        <h2 class="text-center text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
            🌐 Choose Language
        </h2>

        @php
            $country = request()->segment(1) ?? 'IN';
        @endphp

        <!-- BUTTONS -->
        <div class="flex flex-wrap justify-center gap-4">

            <a href="{{ url($country.'/gu') }}"
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-orange-400 to-orange-600 text-white font-semibold shadow-lg hover:scale-105 transition">
                ગુજરાતી 🇮🇳
            </a>

            <a href="{{ url($country.'/hi') }}"
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-400 to-green-600 text-white font-semibold shadow-lg hover:scale-105 transition">
                हिन्दी 🇮🇳
            </a>

            <a href="{{ url($country.'/en') }}"
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-400 to-blue-600 text-white font-semibold shadow-lg hover:scale-105 transition">
                English 🇺🇸
            </a>

        </div>

    </div>

</div>

</body>
</html>