<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AccessLevelSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(BookSeeder::class);
    }
}
