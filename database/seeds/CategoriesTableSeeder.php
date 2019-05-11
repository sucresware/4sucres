<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        Category::firstOrCreate(['name' => '#annonces', 'restricted' => true]);
        Category::firstOrCreate(['name' => '#général']);
        Category::firstOrCreate(['name' => '#lifehacks']);
        Category::firstOrCreate(['name' => '#jeux']);
        Category::firstOrCreate(['name' => '#shitpost']);
    }
}
