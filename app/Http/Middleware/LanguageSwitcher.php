<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check URL parameter
        if ($request->has('lang')) {
            $language = $request->get('lang');
            if (in_array($language, ['en', 'es'])) {
                session(['locale' => $language]);
            }
        }

        // Set language from session or default to English
        $locale = session('locale', 'en');
        App::setLocale($locale);

        return $next($request);
    }
}
