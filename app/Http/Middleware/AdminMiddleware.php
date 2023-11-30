<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    const ADMIN_ROLE = 'admin';
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === self::ADMIN_ROLE) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorized , Only admins can perform this action'], 403);
        }       
    }

    

    
}
