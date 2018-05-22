<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('name') !== 'admin') {
            return response()->json('Unauthorized', 401);
        }
        return $next($request);
    }
}
