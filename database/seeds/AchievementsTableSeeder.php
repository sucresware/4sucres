<?php

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        Achievement::updateOrCreate(['name' => 'Bêta-Sucreur'], ['image' => 'beta.png', 'description' => 'A été présent quand 4sucres n’était qu’un sujet de troll']);
        Achievement::updateOrCreate(['name' => 'QUOI?!'], ['image' => 'olinux.png', 'description' => 'A été (est toujours?) un proche d\'Olinux']);
        Achievement::updateOrCreate(['name' => 'La CHANCE'], ['image' => '100cm.png', 'description' => 'Avoir été le seul a atteindre les 100.00 cm sans tricher sur LeBunker']);
        Achievement::updateOrCreate(['name' => 'Tu veux du ponche ?'], ['image' => 'onche.png', 'description' => 'Avoir fait le choix d\'indiquer son appartenance au forum alternatif onche.party']);
        Achievement::updateOrCreate(['name' => 'Bunkered'], ['image' => 'lebunker.png', 'description' => 'Avoir fait le choix d\'indiquer son appartenance au forum alternatif lebunker.net']);
        Achievement::updateOrCreate(['name' => 'Noëliste'], ['image' => 'ave.png', 'description' => 'Avoir fait le choix d\'indiquer son appartenance au forum alternatif avenoel.org']);
        Achievement::updateOrCreate(['name' => 'ISSOU !'], ['image' => 'jvc.png', 'description' => 'Avoir fait le choix d\'indiquer son appartenance au forum jeuxvideo.com']);
        Achievement::updateOrCreate(['name' => 'Ça fait 6 sucres'], ['image' => '2sucres.png', 'description' => 'Avoir fait le choix d\'indiquer son appartenance au forum alternatif 2sucres.org']);
        Achievement::updateOrCreate(['name' => 'Esprit libre'], ['image' => 'beta.png', 'description' => 'Avoir fait de l\'indépendance lors de son inscription']);
    }
}
