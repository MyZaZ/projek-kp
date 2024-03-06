<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Operator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->akses == 'operator' || $request->user()->akses == 'admin' ) {
            return $next($request);
        }

        abort(403, 'Akses khusus Operator');
    }
}
