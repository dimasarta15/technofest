<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = request()->segment(1);
        $langs = ['id', 'en'];

        if (!empty($locale)) {
            
            if (in_array($locale, $langs)) {
                App::setLocale($locale);
                Session::put('lang', "$locale.");
            } else {
                Session::put('lang', "");
            }
        }

        return $next($request);
    }
}
