<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as IlluminateAuthenticate;
use Illuminate\Support\Facades\Auth;

class ProtectedRoutes extends IlluminateAuthenticate
{
    public function handle($request, Closure $next, ...$guards): mixed
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        return parent::handle($request, $next, ...$guards);
    }
}
