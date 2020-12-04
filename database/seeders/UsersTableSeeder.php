<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        if (config('app.env') === 'local') {
            User::firstOrCreate([
                'email' => 'sr@mgk.dev',
            ], [
                'name'              => 'YvonEnbaver',
                'display_name'      => 'YvonEnbaver',
                'shown_role'        => 'L\'élite des sucres',
                'password'          => \Hash::make('1234'),
                'email_verified_at' => now(),
            ])->assignRole('admin');

            User::firstOrCreate([
                'email' => 'lorem@ipsum.dev',
            ], [
                'name'              => 'Hawezo',
                'display_name'      => 'Hawezo',
                'shown_role'        => 'gbesoindundeuxiemecompte',
                'password'          => \Hash::make('1234'),
                'email_verified_at' => now(),
            ])->assignRole('admin');
        }
    }
}
