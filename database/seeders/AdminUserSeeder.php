<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'fname' => 'John',
            'lname' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'username' => 'john',
            'password' => bcrypt('password'),
            'dob' => '1990-12-26',
            'age' => 31,
            'address' => '1600 Pennsylvania avenue',
            'role' => 'admin',
            'points' => '10000',
            'access_level' => 'Adult Exclusive',
            'email_verified_at' => \Carbon\Carbon::now(),

        ]);
    }
}
