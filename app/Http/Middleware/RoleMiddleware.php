<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Exception;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (
            in_array('owner', $roles, true) ||
            (auth()->id() === (int)$request->user_id || auth()->id() === (int)$request->id)
        ) {
            return $next($request);
        }

        if (!in_array($user->role, $roles, false)) {
            throw new Exception('You do not have the right permissions');
        }

        return $next($request);
    }
}
