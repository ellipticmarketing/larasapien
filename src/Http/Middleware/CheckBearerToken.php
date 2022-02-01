<?php

namespace EllipticMarketing\Larasapien\Http\Middleware;

use Closure;

class CheckBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null(config('larasapien.token')) || $request->bearerToken() != config('larasapien.token')) {
            abort(403);
        }

        return $next($request);
    }
}
