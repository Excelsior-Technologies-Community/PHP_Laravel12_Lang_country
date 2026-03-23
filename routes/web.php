<?php

use Illuminate\Support\Facades\Route;

Route::prefix('{country}/{lang}')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

});