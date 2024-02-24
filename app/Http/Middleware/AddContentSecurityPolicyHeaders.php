<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddContentSecurityPolicyHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('Content-Security-Policy', "block-all-mixed-content; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net " . env('CUSTOM_VITE_CSP_DOMAIN') . "/resources/css/app.css; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:* " . env('CUSTOM_VITE_CSP_DOMAIN') . "/resources/js/app.js " . env('CUSTOM_VITE_CSP_DOMAIN') . "/resources/js/bootstrap.js https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js " . env('CUSTOM_VITE_CSP_DOMAIN') . "/node_modules/.vite/deps/alpinejs.js " . env('CUSTOM_VITE_CSP_DOMAIN') . "/node_modules/.vite/deps/axios.js " . env('CUSTOM_VITE_CSP_DOMAIN') . "/node_modules/.vite/deps/chunk-CSAU5B4Q.js " . env('CUSTOM_VITE_CSP_DOMAIN') . "/@vite/client " . env('CUSTOM_VITE_CSP_DOMAIN') . "/node_modules/vite/dist/client/env.mjs ; img-src * 'self' data: https; connect-src 'self' ws://*:5173; font-src 'self' https://fonts.bunny.net https://fonts.gstatic.com/; frame-src 'self'; media-src 'self'; object-src 'none';");

        return $response;
    }
}
