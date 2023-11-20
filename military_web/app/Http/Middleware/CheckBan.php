<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class CheckBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->ban_expiration && Carbon::parse($user->ban_expiration)->isPast()) {
            $user->ban_expiration = null;
        }

        else if ($user && $user->ban_expiration) {
            return redirect()->back()->with('error', 'Неможливо виконати цю дію. Вас було заблоковано на платформі.');
        }

        return $next($request);
    }
}
