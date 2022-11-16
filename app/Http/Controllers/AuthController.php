<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * @group Authentication
 *
 * Manage Extra
 */
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Authenticate a user
     */
    public function login(Request $request)
    {
        $user = $this->authService->login($request->only('email', 'password'));

        return response()->json(['data' => $user], 200);
    }

    /**
     * Create a user account
     */
    public function register(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'dob' => 'required',
            'address' => 'required|string',
        ])->validate();

        $user = $this->authService->register($request->all());

        return response()->json(['data' => $user], 201);
    }
}
