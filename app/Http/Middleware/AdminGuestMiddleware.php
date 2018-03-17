<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class AdminGuestMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!app('auth')->guard('admin')->guest()) {
            return redirect('/admin');
        }
        return $next($request);
    }
}
