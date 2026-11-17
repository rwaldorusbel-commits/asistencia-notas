<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Busca en sesión, si no hay, busca en la cookie, si no, usa el .env
        $locale = session('locale', $request->cookie('locale', config('app.locale')));

        if (array_key_exists($locale, config('app.available_locales'))) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
