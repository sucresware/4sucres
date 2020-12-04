<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        Category::updateOrCreate(['id' => Category::CATEGORY_ANNOUNCES], [
            'name' => '#annonces',
            'order' => 1,
            'can_post' => ['admin', 'moderator'],
        ]);

        Category::updateOrCreate(['id' => 2], [
            'name' => '#général',
            'order' => 5,
        ]);

        Category::updateOrCreate(['id' => 3], [
            'name' => '#lifehacks',
            'order' => 10,
        ]);

        Category::updateOrCreate(['id' => 4], [
            'name' => '#jeux',
            'order' => 10,
        ]);

        Category::updateOrCreate(['id' => Category::CATEGORY_SHITPOST], [
            'name' => '#shitpost',
            'order' => 999,
        ]);

        // Category::updateOrCreate(['id' => 6], [
        //     'name'     => '#unleashed',
        //     'order'    => 1,
        //     'can_post' => ['admin', 'moderator', 'supporter'],
        //     'can_view' => ['admin', 'moderator', 'supporter'],
        // ]);

        Category::updateOrCreate(['id' => 7], [
            'name' => '#nsfw',
            'order' => 10,
            'nsfw' => true,
        ]);

        Category::updateOrCreate(['id' => 8], [
            'name' => '#tech',
            'order' => 10,
        ]);

        Category::updateOrCreate(['id' => 9], [
            'name' => '#anime',
            'order' => 10,
        ]);

        Category::updateOrCreate(['id' => 10], [
            'name' => '#pol',
            'order' => 10,
        ]);

        Category::updateOrCreate(['id' => 11], [
            'name' => '#vidéothèque',
            'order' => 10,
        ]);

        Category::updateOrCreate(['id' => 12], [
            'name' => '#olinux',
            'order' => 10,
        ]);
    }
}
