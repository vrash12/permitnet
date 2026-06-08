<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (! session('is_logged_in')) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login first.');
        }

        return $next($request);
    }
}