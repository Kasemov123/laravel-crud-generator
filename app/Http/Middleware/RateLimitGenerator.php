<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitGenerator
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'generator:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return response()->json(['error' => 'Too many requests'], 429);
        }
        
        RateLimiter::hit($key, 60);
        
        return $next($request);
    }
}
