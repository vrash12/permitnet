<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('is_logged_in')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}