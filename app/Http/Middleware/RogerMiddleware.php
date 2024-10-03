<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RogerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //aborta ao menos que seja seja verdadeiro...Response::HTTP_FORBIDDEN MESMO QUE 403
        abort_unless($request->user()->email == 'roger@gmail.com', Response::HTTP_FORBIDDEN);
        return $next($request);
    }
}
