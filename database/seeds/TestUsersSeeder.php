<?php

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

/**
 * Seeds the database with test users.
 *
 * @author Enzo Innocenzi <enzo@innocenzi.dev>
 */
class TestUsersSeeder extends Seeder
{
    /**
     * Map of test users with test roles.
     *
     * @var array
     */
    private $map = [
        'dev'   => Role::DEVELOPER,
        'admin' => Role::ADMINISTRATOR,
        'mod'   => Role::MODERATOR,
        'user'  => Role::USER,
    ];

    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach ($this->map as $username => $role) {
            User::firstOrCreate(['username' => $username], [
                'display_name' => $username,
                'email'        => "{$username}@localhost",
                'password'     => bcrypt($username),
            ])->assignRole($role);
        }
    }
}
