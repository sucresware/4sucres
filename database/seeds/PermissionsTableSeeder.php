<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        app()['cache']->forget('spatie.permission.cache');

        $permissions = [
        ];

        // foreach ($permissions as $k => $permission) {
        //     if (Permission::where('name', $permission)->first() == null) {
        //         $p = new Permission::create([
        //             'name'
        //         ];
        //         $p->name = $permission;
        //         $p->guard_name = 'web';
        //         $p->save();
        //     }
        // }
    }
}
