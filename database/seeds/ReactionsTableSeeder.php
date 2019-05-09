<?php

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Reaction;

class ReactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        Reaction::updateOrCreate(['id' => 1], ['name' => 'Vénère', 'image' => 'angry.png']);
        Reaction::updateOrCreate(['id' => 2], ['name' => 'Onche', 'image' => 'happy.png']);
        Reaction::updateOrCreate(['id' => 3], ['name' => 'Love', 'image' => 'love.png']);
        Reaction::updateOrCreate(['id' => 4], ['name' => 'Oh', 'image' => 'oh.png']);
        Reaction::updateOrCreate(['id' => 5], ['name' => 'Sad', 'image' => 'sad.png']);
        Reaction::updateOrCreate(['id' => 6], ['name' => 'Sick', 'image' => 'sick.png']);
        Reaction::updateOrCreate(['id' => 7], ['name' => 'Sueur', 'image' => 'sueur.png']);
        Reaction::updateOrCreate(['id' => 8], ['name' => 'What', 'image' => 'what.png']);
    }
}
