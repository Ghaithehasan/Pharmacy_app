<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
// dd();
        $local = $request->header('Accept-Language')?$request->header('Accept-Language'):'en';
        // dd($local);
        if($local)
        {
            app()->setLocale($local);
            // dd(app()->getLocale());
        }

        return $next($request);
    }
}
