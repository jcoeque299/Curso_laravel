<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        $user = $request->user('api');

        if (! $user || ! in_array($user->role, $roles)) {
            dump($roles);
            dump($request);
            dump($user);
            abort(403, 'Unauthorized');
        }

        return $next($request);

    }
}
