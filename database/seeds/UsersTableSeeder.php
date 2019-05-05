<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        User::firstOrCreate([
            'email' => 'sr@mgk.dev',
        ], [
            'name' => 'YvonEnvaber',
            'password' => \Hash::make('1234'),
        ]);

        // User::firstOrCreate([
        //     'email' => '',
        // ], [
        //     'name' => 'Inspecteur_Olivier',
        //     'password' => \Hash::make('1234'),
        // ]);
    }
}
