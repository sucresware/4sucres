<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Category::firstOrCreate(['name' => '#announces', 'restricted' => true]);
        Category::firstOrCreate(['name' => '#général',]);
        Category::firstOrCreate(['name' => '#lifehacks',]);
        Category::firstOrCreate(['name' => '#jeux',]);
        Category::firstOrCreate(['name' => '#shitpost',]);
    }
}
