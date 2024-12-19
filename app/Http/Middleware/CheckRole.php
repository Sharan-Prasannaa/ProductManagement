<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'customer') {
            $allowedRoutes = [
                'orders/products',
                'orders/cart',
                'orders/checkout',
            ];

            if ($request->is('orders/*/add-to-cart') && $request->method() === 'POST') {
                return $next($request);
            }
            // Check if the current request matches any allowed routes
            foreach ($allowedRoutes as $route) {
                if ($request->is($route)) {
                    return $next($request);
                }
            }
            return redirect('orders/products');
        }
        return $next($request);
    }
}
