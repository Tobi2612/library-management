<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AccessLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('access_levels')->insert([

            [
                'name' => 'Children',
                'slug' => 'children',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Children Exclusive',
                'slug' => 'children-exclusive',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Youth',
                'slug' => 'youth',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Youth Exclusive',
                'slug' => 'youth-exclusive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adult',
                'slug' => 'adult',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adult Exclusive',
                'slug' => 'adult-exclusive',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Senior',
                'slug' => 'senior',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Senior Exclusive',
                'slug' => 'senior-exclusive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
