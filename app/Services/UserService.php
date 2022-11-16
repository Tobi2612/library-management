<?php

namespace App\Services;


use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Exception;

class UserService
{

    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }

    /**
     * Register new user.
     */
    public function AdminCreateUser(array $data): User
    {
        $this->authservice->validateUsername($data['username']);

        $age = $this->authservice->calculateAge($data['dob']);
        $access_level = $this->authservice->calculateAccessLevel($age, 0);

        $data['password'] = Hash::make($data['password']);
        $data['age'] = $age;
        $data['access_level'] = $access_level;
        $data['role'] = $data['role'];
        $data['points'] = $data['points'] ?? 0;
        $data['status'] = 'active';

        $user = User::create($data);

        return $user;
    }

    /**
     * Return information about all users to admin.
     *
     * @return mixed
     */
    public function getAllUsers()
    {
        return User::paginate(50);
    }

    /**
     * Return all information about a user.
     *
     * @param $id
     */
    public function getUser(int $id): User
    {
        $user = User::findOrFail($id);

        return $user;
    }


    /**
     * Update a user.
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateUser(int $id, array $data)
    {

        $user = User::findOrFail($id);
        $logged_user = User::find(auth()->id());

        if (array_key_exists('username', $data)) {
            $this->authservice->validateUsername($data['username']);
            $user->username = $data['username'] ?? $user->username;
        }


        $user->fname = $data['fname'] ?? $user->fname;
        $user->lname = $data['lname'] ?? $user->lname;
        $user->address = $data['address'] ?? $user->address;


        if ($logged_user->role === 'admin') {
            $user->role = $data['role'] ?? $user->role;
            $user->points = $data['points'] ?? $user->points;
            $user->status = $data['status'] ?? $user->status;
        }

        if (array_key_exists('dob', $data)) {
            $user->dob = $data['dob'];
            $user->age = $this->authservice->calculateAge($user->dob);
            $user->access_level = $this->authservice->calculateAccessLevel($user->age, $user->points) ?? $user->access_level;
        }


        $user->save();
        return $user;
    }



    /**
     * Update user role.
     *
     * @return mixed
     */
    public function updateUserRole(int $id, string $role)
    {
        $user = User::findOrFail($id);
        $user->role = $role;

        $user->save();

        return $user;
    }

    public function updateUserStatus(int $id, string $status)
    {
        $user = User::findOrFail($id);
        $user->status = $status;

        $user->save();

        return $user;
    }

    /**
     * Deletes a user.
     */
    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);

        $user->email .= '-' . date('Y-m-d h:m:s:a');
        $user->save();
        $user->delete($id);

        return $user;
    }
}
