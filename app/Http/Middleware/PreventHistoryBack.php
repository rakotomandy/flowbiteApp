<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventHistoryBack
{
    /**
     * Handle an incoming request.
     *
     * This middleware prevents users from seeing cached pages after logout
     * or navigating back in the browser. It sets HTTP headers to instruct
     * the browser not to cache the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only modify GET or HEAD requests (safe requests)
        if (in_array($request->method(), ['GET', 'HEAD'])) {

            // Process the request and get the response
            $response = $next($request);

            // Add headers to prevent caching in the browser
            return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        }

        // For non-GET/HEAD requests, just pass through the response
        return $next($request);
    }
}
