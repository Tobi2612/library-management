<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index(Request $request): JsonResponse
    {
        $user = $this->user->getAllUsers($request->all());

        return response()->json(['data' => $user]);
    }

    public function AdminCreateUser(Request $request): JsonResponse
    {

        Validator::make($request->all(), [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'dob' => 'required',
            'address' => 'required|string',
            'role' => 'required',
            'address' => 'required|string',
            'points' => 'required',
        ])->validate();

        $user = $this->user->AdminCreateUser($request->all());

        return response()->json(['data' => $user]);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->user->getUser($id);

        return response()->json(['data' => $user]);
    }



    public function update(Request $request): JsonResponse
    {
        $payload = Validator::make($request->all(), [
            'fname' => 'nullable|string',
            'lname' => 'nullable|string',
            'username' => 'nullable|string',
            'dob' => 'nullable',
            'address' => 'nullable|string',
            'role' => 'nullable|string',
            'points' => 'nullable|integer',
        ])->validate();

        $user = $this->user->updateUser($request->id, $payload);

        return response()->json(['data' => $user]);
    }



    public function updateRole(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'role' => 'required',
        ])->validate();

        $user = $this->user->updateUserRole($request->id, $request->role);

        return response()->json(['data' => $user]);
    }

    public function updateUserStatus(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ])->validate();

        $user = $this->user->updateUserStatus($request->id, $request->status);

        return response()->json(['data' => $user]);
    }


    public function destroy(int $id): JsonResponse
    {
        $user = $this->user->deleteUser($id);

        return response()->json(['data' => $user]);
    }
}
