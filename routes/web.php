<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLangCountry;

Route::get('/', function () {

    if (
        session()->has('last_country') &&
        session()->has('last_language')
    ) {

        return redirect(
            '/'
            . session('last_country')
            . '/'
            . session('last_language')
        );
    }

    return redirect('/IN/gu');

});


Route::middleware([
    SetLangCountry::class
])
->group(function () {

    Route::get('/{country}/{lang}', function () {

        return view('welcome');

    });

});