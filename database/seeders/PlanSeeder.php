<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;


use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([

            [
                'name' => 'Free',
                'duration' => 'forever',
                'price' => 0,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Bronze',
                'duration' => '30',
                'price' => 30,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Silver',
                'duration' => '30',
                'price' => 10,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Gold',
                'duration' => '30',
                'price' => 50,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
