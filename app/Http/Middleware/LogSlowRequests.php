<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogSlowRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        \Log::debug('LogSlowRequests middleware hit');
        
        $response = $next($request);
        
        $duration = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
        
        if ($duration > 200) {
            Log::warning('Slow request detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'duration' => round($duration, 2) . 'ms',
                'ip' => $request->ip(),
                'user_id' => $request->user()?->id,
                'request_id' => uniqid(),
                'memory_usage' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . 'MB',
            ]);
        }
        
        return $response;
    }
} 