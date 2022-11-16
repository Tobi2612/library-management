<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
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
        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Not authenticated'], 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expired'], 401); // Expired login status
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token invalid'], 401); // Invalid login status
        } catch (JWTException $e) {
            return response()->json(['message' => 'Authorization token not found'], 401); // Unauthorized status
        }

        return $next($request);
    }
}
