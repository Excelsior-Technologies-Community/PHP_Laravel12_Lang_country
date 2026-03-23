# PHP_Laravel12_Lang_Country

## Project Description

**PHP_Laravel12_Lang_Country** is a Laravel 12 application that demonstrates how to implement a **multi-language + country-based localization system**.

Users can switch between different **Country + Language** combinations (e.g., `/IN/gu`, `/IN/hi`, `/US/en`) directly from the URL. The app automatically sets the locale via Middleware and displays translated content using Laravel's built-in localization.

This project is **beginner-friendly** and helps understand how to use Laravel Middleware, Route Prefixes, and Language Files together.

---

## Features

- 🌍 Country + Language based URL routing (`/IN/gu`, `/IN/hi`, `/US/en`)
- 🔄 Dynamic Locale Switching via `SetLangCountry` Middleware
- 🗂️ Separate language files per locale (`en`, `gu`, `hi`)
- ⚙️ Custom `lang-country.php` config with country names & default languages
- 🌑 Dark Mode UI with Tailwind CSS CDN
- 🔒 Fallback to country's default language if invalid lang is given

---

## Technologies Used

| Technology | Purpose |
|---|---|
| PHP 8+ | Backend Language |
| Laravel 12 | PHP Framework |
| MySQL | Database |
| Middleware | Dynamic locale setting per request |
| Blade Templates | Frontend Views |
| Tailwind CSS (CDN) | UI Styling |

---

## How It Works

1. User visits a URL like `/IN/gu`, `/IN/hi`, or `/US/en`.
2. The `SetLangCountry` middleware reads `segment(1)` (country) and `segment(2)` (language) from the URL.
3. Middleware checks `config/lang-country.php` to validate the country and language.
4. If valid → `App::setLocale($lang)` is called.
5. If language is invalid → fallback to that country's `default_lang`.
6. Blade view shows translated text using `__('messages.welcome')`.

---

## Installation Steps

---

### STEP 1: Create Laravel 12 Project

Open terminal / CMD and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_Lang_Country "12.*"
```

Go inside project:

```bash
cd PHP_Laravel12_Lang_Country
```

> This installs a fresh Laravel 12 project and moves into the project folder.

---

### STEP 2: Database Setup

Update `.env` with your database details:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:your_generated_key_here
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=php_laravel12_lang_country
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

Create database in MySQL / phpMyAdmin:

```
Database name: php_laravel12_lang_country
```

Then run:

```bash
php artisan migrate
```

> Connects Laravel with MySQL and creates default tables.

---

### STEP 3: Create Language Files

Create folders and translation files for each language inside `lang/`:

```
lang/
├── en/
│   └── messages.php
├── gu/
│   └── messages.php
└── hi/
    └── messages.php
```

#### `lang/en/messages.php`

```php
<?php

return [
    'welcome' => 'Welcome to our Multi-Country Store!',
];
```

#### `lang/gu/messages.php`

```php
<?php

return [
    'welcome' => 'અમારી મલ્ટી-કન્ટ્રી સ્ટોરમાં તમારું સ્વાગત છે!',
];
```

#### `lang/hi/messages.php`

```php
<?php

return [
    'welcome' => 'हमारे मल्टी-कंट्री स्टोर में आपका स्वागत है!',
];
```

> Each file contains key-value translations for that language.
> Used in Blade via `__('messages.welcome')`.

---

### STEP 4: Create Config File

Create `config/lang-country.php`:

```php
<?php

return [
    'supported' => [
        'IN' => [
            'langs'        => ['gu', 'hi', 'en'], // India supports all 3 languages
            'name'         => 'India',
            'default_lang' => 'gu'                // Default fallback for India
        ],
        'US' => [
            'langs'        => ['en'],
            'name'         => 'USA',
            'default_lang' => 'en'                // Default fallback for USA
        ],
    ],
];
```

> Defines which country supports which languages.
> If user requests an unsupported language, `default_lang` is used as fallback.

---

### STEP 5: Create Middleware

Run:

```bash
php artisan make:middleware SetLangCountry
```

Open: `app/Http/Middleware/SetLangCountry.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLangCountry
{
    public function handle(Request $request, Closure $next): Response
    {
       
        $country = strtoupper($request->segment(1));
        $lang    = $request->segment(2);

        $supported = config('lang-country.supported');


        if (isset($supported[$country])) {

           
            if (in_array($lang, $supported[$country]['langs'])) {
                App::setLocale($lang);
            } else {

                App::setLocale($supported[$country]['default_lang']);
            }
        }

        return $next($request);
    }
}
```

> Middleware reads country + language from the URL and sets the app locale.
> Falls back to country's `default_lang` if the given language is not supported.

---

### STEP 6: Register Middleware

Open: `bootstrap/app.php`

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register SetLangCountry middleware globally
        $middleware->append(\App\Http\Middleware\SetLangCountry::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

> Registers the middleware globally so it runs on every request automatically.

---

### STEP 7: Add Routes

Open: `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;

// Country + Language prefix route group
// URL format: /{country}/{lang}  e.g. /IN/gu, /IN/hi, /US/en
Route::prefix('{country}/{lang}')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

});
```

> Uses `Route::prefix()` to group all routes under `/{country}/{lang}`.
> Clean and scalable — add more routes inside this group as needed.

---

### STEP 8: Create Blade View

Open: `resources/views/welcome.blade.php`

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel 12 - Lang & Country</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS via CDN (no build step needed) -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white">

            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center bg-white dark:bg-gray-800 rounded-lg shadow-xl">

                <!-- Translated Welcome Message -->
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('messages.welcome') }}
                </h1>

                <!-- Country and Language Info -->
                <div class="mt-6 p-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        🌍 **Country:** <span class="font-bold text-blue-500">{{ request()->segment(1) }}</span>
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        🗣️ **Language:** <span class="font-bold text-green-500">{{ app()->getLocale() }}</span>
                    </p>
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <!-- Language Switcher Buttons -->
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ url('/IN/gu') }}" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">ગુજરાતી (IN)</a>
                    <a href="{{ url('/IN/hi') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">हिन्दी (IN)</a>
                    <a href="{{ url('/US/en') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">English (US)</a>
                </div>

            </div>
        </div>
    </body>
</html>
```

> Shows translated welcome message + current country & language info.
> 3 buttons to switch between Gujarati (IN), Hindi (IN), and English (US).

---

### STEP 9: Run the App

Start dev server:

```bash
php artisan serve
```

Open in browser and test:

```
http://127.0.0.1:8000/IN/gu   →  ગુજરાતી
http://127.0.0.1:8000/IN/hi   →  हिन्दी
http://127.0.0.1:8000/US/en   →  English
```

> Starts local server. Visit any country/language URL to see the translation in action.

---
<img width="1919" height="971" alt="Screenshot 2026-03-23 150737" src="https://github.com/user-attachments/assets/b24e2e0f-562a-49c9-a7cb-4ede4a8c9467" /><img width="1916" height="969" alt="Screenshot 2026-03-23 150747" src="https://github.com/user-attachments/assets/ead9436f-01e9-4123-b363-0e8de7595e39" />

<img width="1907" height="975" alt="Screenshot 2026-03-23 150725" src="https://github.com/user-attachments/assets/909604dd-89b9-4c45-9d0b-ddc491f21c07" />


## Expected Output


| URL | Country | Language | Locale | Message Shown |
|---|---|---|---|---|
| `/IN/gu` | India 🇮🇳 | Gujarati | `gu` | અમારી મલ્ટી-કન્ટ્રી સ્ટોરમાં તમારું સ્વાગત છે! |
| `/IN/hi` | India 🇮🇳 | Hindi | `hi` | हमारे मल्टी-कंट्री स्टोर में आपका स्वागत है! |
| `/US/en` | USA 🇺🇸 | English | `en` | Welcome to our Multi-Country Store! |
| `/IN/xx` | India 🇮🇳 | Invalid → fallback | `gu` | અમારી મલ્ટી-કન્ટ્રી સ્ટોરમાં તમારું સ્વાગત છે! |

---

## Project Folder Structure

```
PHP_Laravel12_Lang_Country/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   │       └── SetLangCountry.php     ← Custom Middleware
│   │
│   ├── Models/
│   │   └── User.php
│   │
│   └── Providers/
│
├── bootstrap/
│   └── app.php                        ← Middleware registered here
│
├── config/
│   ├── app.php
│   ├── lang-country.php               ← Custom config (supported countries + langs)
│   └── ...
│
├── database/
│   └── migrations/
│
├── lang/
│   ├── en/
│   │   └── messages.php               ← English translations
│   ├── gu/
│   │   └── messages.php               ← Gujarati translations
│   └── hi/
│       └── messages.php               ← Hindi translations
│
├── resources/
│   └── views/
│       └── welcome.blade.php          ← Main view with language switcher
│
├── routes/
│   └── web.php                        ← Route::prefix('{country}/{lang}') group
│
├── .env                               ← DB + App config
├── artisan
├── composer.json
└── README.md
```

---
