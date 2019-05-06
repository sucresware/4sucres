<?php

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

        User::firstOrCreate([
            'email' => 'sr@mgk.dev',
        ], [
            'name' => 'BandanaRouge',
            'display_name' => 'Sucre au Bandana Rouge',
            'shown_role' => 'L\'élite des sucres',
            'password' => \Hash::make('1234'),
            'email_verified_at' => now(),
        ])->assignRole('admin');

        // User::firstOrCreate([
        //     'email' => '',
        // ], [
        //     'name' => 'Inspecteur_Olivier',
        //     'password' => \Hash::make('1234'),
        // ]);
    }
}
