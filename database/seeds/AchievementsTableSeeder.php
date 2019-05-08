<?php

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        Achievement::firstOrCreate([ 'name' => 'Bêta-Sucreur', ], [ 'image' => 'beta.png', 'description' => 'A été présent quand 4sucres n’était qu’un sujet de troll', ]);
        Achievement::firstOrCreate([ 'name' => 'QUOI?!', ], [ 'image' => 'olinux.png', 'description' => 'A été (est toujours?) un proche d\'Olinux', ]);
        Achievement::firstOrCreate([ 'name' => 'La CHANCE', ], [ 'image' => '100cm.png', 'description' => 'Avoir été le seul a atteindre les 100.00 cm sans tricher sur LeBunker', ]);
        Achievement::firstOrCreate([ 'name' => 'Tu veux du ponche ?', ], [ 'image' => 'onche.png', 'description' => 'Rescapé du forum alternatif onche.party', ]);
        Achievement::firstOrCreate([ 'name' => 'Bunkered', ], [ 'image' => 'lebunker.png', 'description' => 'Rescapé du forum alternatif lebunker.net', ]);
        Achievement::firstOrCreate([ 'name' => 'Noëliste', ], [ 'image' => 'ave.png', 'description' => 'Rescapé du forum alternatif avenoel.org', ]);
        Achievement::firstOrCreate([ 'name' => 'ISSOU !', ], [ 'image' => 'jvc.png', 'description' => 'Rescapé du forum jeuxvideo.com', ]);
    }
}
