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
        // URL માંથી પહેલો ભાગ (Country) અને બીજો ભાગ (Language) પકડો
        // દા.ત. /IN/gu માં segment(1) = IN અને segment(2) = gu
        $country = strtoupper($request->segment(1)); 
        $lang = $request->segment(2);

        $supported = config('lang-country.supported');

        // ૧. ચેક કરો કે આ દેશ આપણા લિસ્ટમાં છે કે નહીં
        if (isset($supported[$country])) {
            
            // ૨. ચેક કરો કે યુઝરે માંગેલી ભાષા તે દેશ માટે માન્ય છે?
            if (in_array($lang, $supported[$country]['langs'])) {
                App::setLocale($lang);
            } else {
                // જો ભાષા ખોટી હોય તો તે દેશની Default ભાષા સેટ કરો
                App::setLocale($supported[$country]['default_lang']);
            }
        }

        return $next($request);
    }
}