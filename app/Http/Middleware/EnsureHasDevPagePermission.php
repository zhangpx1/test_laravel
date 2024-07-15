<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnsureHasDevPagePermission
{
    public function handle($request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->hasPermissionTo('view-dev-page')) {
            return redirect('/');
        }
        return $next($request);
    }

}
