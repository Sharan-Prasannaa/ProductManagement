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
        // Skip redirection if the user is already on the customer route
        if (Auth::check() && Auth::user()->role == 'customer') {
            if ($request->is('orders/products')) {
                return $next($request); // Allow access to the customer route
            }

            return redirect('orders/products'); // Redirect customers to their dashboard
        }

        return $next($request);
    }
}
