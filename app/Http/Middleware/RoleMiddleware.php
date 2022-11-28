<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
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
        $roles = is_array($role) ? $role : explode('|', $role);

        if(!$request->user()->hasRole($roles)) {
            return response()->json("Forbidden error", 403);
        }

        return $next($request);
    }
}
