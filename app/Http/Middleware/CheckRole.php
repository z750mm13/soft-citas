<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (! $request->user()->admin ) {
            abort(403, "No tienes autorización para ingresar.");
        }
        return $next($request);
    }
}
