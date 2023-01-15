<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as IlluminateAuthenticate;
use Illuminate\Support\Facades\Auth;

class Authenticate extends IlluminateAuthenticate
{
    /**
     * Handle an incoming request.
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {

        if (!Auth::check()) {
            return redirect('/');
        }

        return parent::handle($request, $next, ...$guards);
    }
}
