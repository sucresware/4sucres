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
        $user = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'user']);

        Permission::firstOrCreate(['name' => 'create discussions']);
        Permission::firstOrCreate(['name' => 'moderate discussions']);
        Permission::firstOrCreate(['name' => 'use restricted categories']);

        $admin->givePermissionTo('create discussions');
        $admin->givePermissionTo('moderate discussions');
        $admin->givePermissionTo('use restricted categories');

        $moderator->givePermissionTo('create discussions');
        $moderator->givePermissionTo('moderate discussions');
        $moderator->givePermissionTo('use restricted categories');

        $user->givePermissionTo('create discussions');
    }
}
