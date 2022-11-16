<?php

namespace App\Services;

use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    /**
     * Login using username and password
     * @param array $request
     */
    public function login(array $request)
    {

        if (!$token = Auth::attempt($request)) {
            throw new Exception("Invalid credentials");
        }

        $user = User::find(auth()->id());

        $age = $this->calculateAge($user->dob);
        if ($age !== $user->age) {
            $user->age = $age;

            $access_level = $this->authservice->calculateAccessLevel($user->age, $user->points);
            if ($access_level !== $user->access_level) {
                $user->access_level = $access_level;
            }

            $user->save();
        }


        $user['token'] = $token;

        return $user;
    }

    /**
     * Registers a new user
     * @param array $data
     */
    public function register(array $data): User
    {
        $this->validateUsername($data['username']);

        $age = $this->calculateAge($data['dob']);
        $access_level = $this->calculateAccessLevel($age, 0);

        $data['password'] = Hash::make($data['password']);
        $data['age'] = $age;
        $data['access_level'] = $access_level;
        $data['role'] = 'reader';
        $data['points'] = 0;
        $data['current_plan'] = 1;
        $data['status'] = 'active';


        DB::beginTransaction();

        $user = User::create($data);


        $token = Auth::login($user);

        $user['token'] = $token;

        DB::commit();


        return $user;
    }


    public function calculateAge($dob)
    {
        $cdob = new DateTime($dob);

        $now = new DateTime();

        $difference = $now->diff($cdob);

        $age = $difference->y;

        return  $age;
    }

    public function calculateAccessLevel($age, $points)
    {
        if ($age >= 7 && $age < 15) {
            return $points >= 10 ? 'Children Exclusive' : 'Children';
        } else if ($age >= 15 && $age <= 24) {
            return $points >= 10 ? 'Youth Exclusive' : 'Youth';
        } else if ($age >= 25 && $age <= 49) {
            return $points >= 10 ? 'Adult Exclusive' : 'Adult';
        } else if ($age >= 50) {
            return $points >= 10 ? 'Senior Exclusive' : 'Senior';
        }
    }

    public function validateUsername($username)
    {

        //check for white spaces in username

        if (!preg_match('/^\S*$/', $username)) {
            throw new Exception("Incorrect Username format");
        }

        // Must start with letter
        // 1-20 characters
        // Letters and numbers only
        if (!preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{0,20}$/', $username)) {
            throw new Exception("Incorrect Username format");
        }
    }
}
