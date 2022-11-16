<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([

            [
                'title' => 'The adventures of Sherlock Holmes',
                'edition' => '3',
                'description' => 'Follows the life of a legendary detective and his sidekick as the solve cases.',
                'prologue' => '...',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Harry Potter and the chamber of secrets',
                'edition' => '1',
                'description' => 'Story of harry potter as he resumes his 2nd year at hogwarts',
                'prologue' => '...',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Harry Potter and the deathly hallows',
                'edition' => '1',
                'description' => 'Story of harry potter as he resumes his 2nd year at hogwarts',
                'prologue' => '...',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
