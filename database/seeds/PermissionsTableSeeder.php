<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        app()['cache']->forget('spatie.permission.cache');

        $admin = Role::create(['guard_name' => 'web', 'name' => 'admin']);
        $moderator = Role::create(['guard_name' => 'web', 'name' => 'moderator']);
        $user = Role::create(['guard_name' => 'web', 'name' => 'user']);

        Permission::create(['name' => 'create discussions']);

        $admin->givePermissionTo('create discussions');
    }
}
