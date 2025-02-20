<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $languages = config('languages');
        if (isset($request->lang)) {
            if (array_key_exists($request->lang, $languages)) {
                app()->setLocale($request->lang);
                session()->put('locale', $request->lang);
            }
        } elseif (array_key_exists($request->segment(1), $languages)) {
            app()->setLocale($request->segment(1));
            session()->put('locale', $request->segment(1));
        } else {
            app()->setLocale('en');
            session()->put('locale', 'en');
        }
        return $next($request);
    }
}

