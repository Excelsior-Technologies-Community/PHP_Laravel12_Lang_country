<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLangCountry
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $country = strtoupper(
            $request->segment(1)
        );

        $lang = $request->segment(2);

        $supported =
            config('lang-country.supported');

        if(isset($supported[$country])){

            if(
                in_array(
                    $lang,
                    $supported[$country]['langs']
                )
            ){

                App::setLocale($lang);

                session()->flash(
                    'success',
                    'Language changed successfully!'
                );

            }else{

                App::setLocale(
                    $supported[$country]['default_lang']
                );

                session()->flash(
                    'error',
                    'Unsupported language loaded'
                );

            }

            $history =
                session('history',[]);

            $history[]=[

                'country'=>$country,

                'language'=>App::getLocale(),

                'time'=>now()->format(
                    'd M Y h:i A'
                )

            ];

            session([
                'history'=>$history
            ]);


            $counter=
                session(
                    'lang_count',
                    []
                );

            $currentLang=
                App::getLocale();

            $counter[$currentLang]=
            ($counter[$currentLang]??0)+1;

            session([
                'lang_count'=>$counter
            ]);


            session([

                'last_country'=>$country,

                'last_language'=>
                App::getLocale()

            ]);

        }

        return $next($request);
    }
}