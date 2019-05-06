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

        $admin = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'admin']);
        $moderator = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'moderator']);
        $supporter = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'supporter']);
        $user = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'user']);

        Permission::firstOrCreate(['name' => 'create discussions']);
        Permission::firstOrCreate(['name' => 'bypass discussions guard']);
        Permission::firstOrCreate(['name' => 'bypass users guard']);
        Permission::firstOrCreate(['name' => 'use restricted categories']);
        Permission::firstOrCreate(['name' => 'update shown_role']);

        $admin->givePermissionTo('bypass users guard');
        $admin->givePermissionTo('use restricted categories');
        $admin->givePermissionTo('update shown_role');
        $admin->givePermissionTo('bypass discussions guard');
        $admin->givePermissionTo('create discussions');

        $moderator->givePermissionTo('use restricted categories');
        $moderator->givePermissionTo('update shown_role');
        $moderator->givePermissionTo('bypass discussions guard');
        $moderator->givePermissionTo('create discussions');

        $supporter->givePermissionTo('update shown_role');
        $supporter->givePermissionTo('create discussions');

        $user->givePermissionTo('create discussions');
    }
}
