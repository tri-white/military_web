<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            if (in_array(Auth::user()->role_id, $roles)) {
                return $next($request);
            }
        }

        return redirect()->back()->with('error', 'Недостатньо прав на доступ до даної дії.');
    }
}
