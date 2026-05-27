<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Lang Country</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            transition: .4s;
        }

        .dark-mode {
            background: #111827 !important;
            color: white !important;
        }

        .dark-card {
            background: #1f2937 !important;
            color: white !important;
        }

        .dark-box {
            background: #374151 !important;
            color: white !important;
        }

        .dark-input {
            background: #374151 !important;
            color: white !important;
            border: 1px solid #6b7280 !important;
        }
    </style>
</head>

<body id="body"
    class="bg-gradient-to-r from-indigo-200 via-purple-100 to-pink-100 min-h-screen flex items-center justify-center p-5">

    <div id="mainCard"
        class="bg-white shadow-2xl rounded-3xl p-10 w-full max-w-3xl transition-all duration-500">

        <!-- Header -->

        <div class="flex justify-between items-center mb-6">

            <h1 id="title"
                class="text-4xl font-bold text-indigo-700">

                🌍 {{ __('messages.welcome') }}

            </h1>

            <button
                onclick="toggleDark()"
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">

                🌙 Mode

            </button>

        </div>


        <!-- Alerts -->

        @if(session('success'))

        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">

            {{ session('success') }}

        </div>

        @endif


        @if(session('error'))

        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">

            {{ session('error') }}

        </div>

        @endif


        @php

        $country=request()->segment(1);

        $data=config('lang-country.supported')[$country] ?? null;

        @endphp


        <!-- Country + Language -->

        <div class="grid md:grid-cols-2 gap-5">

            <div id="countryBox"
                class="bg-blue-100 p-5 rounded-2xl text-center shadow">

                <h2 class="text-xl font-bold text-blue-700">
                    Country
                </h2>

                <p class="text-3xl mt-2">

                    {{ request()->segment(1) }}

                </p>

            </div>


            <div id="languageBox2"
                class="bg-green-100 p-5 rounded-2xl text-center shadow">

                <h2 class="text-xl font-bold text-green-700">
                    Language
                </h2>

                <p class="text-3xl mt-2">

                    {{ app()->getLocale() }}

                </p>

            </div>

        </div>


        <!-- Country Detail Card -->

        @if($data)

        <div id="countryDetails"
            class="bg-purple-100 p-5 rounded-2xl text-center shadow mt-6">

            <h2 class="text-2xl font-bold">

                {{ $data['flag'] }}
                {{ $data['name'] }}

            </h2>

            <p class="mt-2">

                Default Language:

                <b>

                    {{ strtoupper($data['default_lang']) }}

                </b>

            </p>

        </div>

        @endif


        <!-- Search -->

        <div class="mt-8">

            <input
                type="text"
                id="searchInput"
                placeholder="Search language..."
                class="w-full border p-3 rounded-xl transition-all"
                onkeyup="searchLanguage()">

        </div>


        <!-- Language Buttons -->

        <div id="languageBox"
            class="flex flex-wrap gap-4 justify-center mt-8">

            <a href="{{ url('/IN/gu') }}"
                class="lang-btn bg-orange-500 text-white px-6 py-3 rounded-xl shadow-lg hover:scale-105 transition">

                Gujarati 🇮🇳

            </a>


            <a href="{{ url('/IN/hi') }}"
                class="lang-btn bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg hover:scale-105 transition">

                Hindi 🇮🇳

            </a>


            <a href="{{ url('/US/en') }}"
                class="lang-btn bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg hover:scale-105 transition">

                English 🇺🇸

            </a>


            <a href="{{ url('/FR/fr') }}"
                class="lang-btn bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg hover:scale-105 transition">

                French 🇫🇷

            </a>

        </div>


        <!-- History -->

        <div class="mt-10">

            <h2 id="historyTitle"
                class="text-2xl font-bold mb-4 text-gray-700">

                🕘 Recent History

            </h2>


            @php

            $history=session('history',[]);

            @endphp


            <div class="space-y-3">

                @forelse(array_reverse($history) as $item)

                <div class="history-item bg-gray-100 p-4 rounded-xl shadow">

                    🌍 {{ $item['country'] }}

                    —

                    🗣️ {{ $item['language'] }}

                    <br>

                    <small>

                        {{ $item['time'] }}

                    </small>

                </div>

                @empty

                <div class="text-gray-500">

                    No history available

                </div>

                @endforelse

            </div>

        </div>


        <!-- Analytics -->

        <div id="analyticsBox"
            class="bg-yellow-100 p-5 rounded-2xl mt-8 shadow">

            <h2 class="text-xl font-bold mb-3">

                📊 Language Analytics

            </h2>


            @foreach(session('lang_count',[]) as $lang=>$count)

            <div>

                {{ strtoupper($lang) }}

                :

                {{ $count }}

                visits

            </div>

            @endforeach

        </div>


        <!-- Last Locale -->

        <div id="lastLocaleBox"
            class="bg-cyan-100 p-5 rounded-2xl mt-8 shadow">

            <h2 class="text-xl font-bold mb-3">

                🔁 Last Selected Locale

            </h2>

            <p>

                Country:

                <b>

                    {{ session('last_country','N/A') }}

                </b>

            </p>

            <p>

                Language:

                <b>

                    {{ strtoupper(session('last_language','N/A')) }}

                </b>

            </p>

        </div>

    </div>


    <script>
        function toggleDark() {

            document.getElementById('body')
                .classList.toggle('dark-mode');

            document.getElementById('mainCard')
                .classList.toggle('dark-card');

            document.getElementById('countryBox')
                .classList.toggle('dark-box');

            document.getElementById('languageBox2')
                .classList.toggle('dark-box');

            document.getElementById('countryDetails')
                ?.classList.toggle('dark-box');

            document.getElementById('analyticsBox')
                ?.classList.toggle('dark-box');

            document.getElementById('lastLocaleBox')
                ?.classList.toggle('dark-box');

            document.getElementById('searchInput')
                .classList.toggle('dark-input');


            document.querySelectorAll('.history-item')
                .forEach((item) => {

                    item.classList.toggle('dark-box');

                });


            document.getElementById('title')
                .classList.toggle('text-white');


            document.getElementById('historyTitle')
                .classList.toggle('text-white');

        }


        function searchLanguage() {

            let input =
                document.getElementById('searchInput')
                .value
                .toLowerCase();


            let buttons =
                document.querySelectorAll('.lang-btn');


            buttons.forEach((btn) => {

                if (
                    btn.innerText
                    .toLowerCase()
                    .includes(input)
                ) {

                    btn.style.display = 'inline-block';

                } else {

                    btn.style.display = 'none';

                }

            });

        }
    </script>

</body>

</html>