<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access admin area.');
        }

        if (!Auth::user()->is_admin) {
            return redirect()->route('shop.index')->with('error', 'Unauthorized. Admin access only.');
        }

        return $next($request);
    }
}
