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

        Achievement::updateOrCreate(['id' => 1 ], ['name' => 'Bêta-Sucreur', 'image' => 'beta.png', 'description' => 'A été présent quand 4sucres n’était qu’un sujet de troll']);
        Achievement::updateOrCreate(['id' => 2 ], ['name' => 'QUOI?!', 'image' => 'olinux.png', 'description' => 'A été (est toujours?) un proche d\'Olinux']);
        Achievement::updateOrCreate(['id' => 3 ], ['name' => 'La CHANCE', 'image' => '100cm.png', 'description' => 'Avoir été le seul a atteindre les 100.00 cm sans tricher sur LeBunker']);
        Achievement::updateOrCreate(['id' => 4 ], ['name' => 'Tu veux du ponche ?', 'image' => 'onche.png', 'description' => 'Revendique son appartenance au forum alternatif onche.party']);
        Achievement::updateOrCreate(['id' => 5 ], ['name' => 'Bunkered', 'image' => 'lebunker.png', 'description' => 'Revendique son appartenance au forum alternatif lebunker.net']);
        Achievement::updateOrCreate(['id' => 6 ], ['name' => 'Noëliste', 'image' => 'ave.png', 'description' => 'Revendique son appartenance au forum alternatif avenoel.org']);
        Achievement::updateOrCreate(['id' => 7 ], ['name' => 'ISSOU !', 'image' => 'jvc.png', 'description' => 'Revendique son appartenance au forum jeuxvideo.com']);
        Achievement::updateOrCreate(['id' => 8 ], ['name' => 'Ça fait 6 sucres', 'image' => '2sucres.png', 'description' => 'Revendique son appartenance au forum alternatif 2sucres.org']);
        Achievement::updateOrCreate(['id' => 9 ], ['name' => 'Esprit libre', 'image' => 'beta.png', 'description' => 'Avoir fait le choix de l\'indépendance lors de son inscription']);
    }
}
