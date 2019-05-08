<?php

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        Achievement::firstOrCreate([
            'image' => 'Premier sucre',
        ], [
            'name' => 'Premier sucre',
            'description' => 'Sucre au Bandana Rouge',
        ]);

        Achievement::firstOrCreate([
            'image' => '',
        ], [
            'name' => 'Sucre indépendant',
            'description' => 'Avoir fait le choix de l\'indépendance',
        ]);

        Achievement::firstOrCreate([
            'image' => 'Premier sucre',
        ], [
            'name' => 'Sucre enfermé',
            'description' => 'Rescapé du forum lebunker.net',
        ]);

        Achievement::firstOrCreate([
            'image' => 'Premier sucre',
        ], [
            'name' => 'Team Noëlistes',
            'description' => 'Rescapé du forum avenoel.org',
        ]);

        Achievement::firstOrCreate([
            'image' => 'Premier sucre',
        ], [
            'name' => 'Team Onche',
            'description' => 'Rescapé du forum oncheparty.org',
        ]);

    }
}
