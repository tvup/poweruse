<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as IlluminateAuthenticate;
use Illuminate\Support\Facades\Auth;

class Authenticate extends IlluminateAuthenticate
{
    public function handle($request, Closure $next, ...$guards): mixed
    {

        if (!Auth::check()) {
            return redirect('/');
        }

        // @phpstan-ignore-next-line
        return parent::handle($request, $next, ...$guards);
    }
}
