<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Import Response

class Operator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next): Response // Gunakan Illuminate\Http\Response
    {
        if ($request->user()->akses == 'operator' || $request->user()->akses == 'admin' ) {
            return $next($request);
        }
        abort(403, 'Akses khusus Operator');
    }
}
