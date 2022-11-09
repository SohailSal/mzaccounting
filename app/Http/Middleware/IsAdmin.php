<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->role !== 'admin') {
            return redirect('home');
        }
        return $next($request);
    }
}
