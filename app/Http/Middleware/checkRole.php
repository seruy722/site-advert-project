<?php

namespace Advert\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == $role) {
                return $next($request);
            }
        }
        return redirect()->route('404');
    }
}
