<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;

class OwnerPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $userId = $request->user_id;
        if (
            (int)$request->user_id === $userId
            || in_array(auth()->user()->role, [Role::ADMIN])
        ) {
            return $next($request);
        }
        return response()->json(['data' => 'Unauthorized'], 401);
    }
}
