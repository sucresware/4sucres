<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database in local environment.
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            TestUsersSeeder::class,
        ]);
    }
}
