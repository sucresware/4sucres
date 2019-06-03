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
        $verified = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'verified']);

        Permission::firstOrCreate(['name' => 'create discussions']);
        Permission::firstOrCreate(['name' => 'bypass discussions guard']);
        Permission::firstOrCreate(['name' => 'bypass users guard']);
        Permission::firstOrCreate(['name' => 'update shown_role']);
        Permission::firstOrCreate(['name' => 'read deleted posts']);
        Permission::firstOrCreate(['name' => 'restore posts']);
        Permission::firstOrCreate(['name' => 'update achievements']);
        Permission::firstOrCreate(['name' => 'update roles']);
        Permission::firstOrCreate(['name' => 'debug mode enabled']);
        Permission::firstOrCreate(['name' => 'ban users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        Permission::firstOrCreate(['name' => 'bypass throttle']);
        Permission::firstOrCreate(['name' => 'upload animated avatars']);
        Permission::firstOrCreate(['name' => 'sync discord emojis']);

        $admin->givePermissionTo('bypass users guard');
        $admin->givePermissionTo('update shown_role');
        $admin->givePermissionTo('bypass discussions guard');
        $admin->givePermissionTo('create discussions');
        $admin->givePermissionTo('restore posts');
        $admin->givePermissionTo('read deleted posts');
        $admin->givePermissionTo('update achievements');
        $admin->givePermissionTo('update roles');
        $admin->givePermissionTo('debug mode enabled');
        $admin->givePermissionTo('ban users');
        $admin->givePermissionTo('delete users');
        $admin->givePermissionTo('bypass throttle');
        $admin->givePermissionTo('upload animated avatars');
        $admin->givePermissionTo('sync discord emojis');

        $moderator->givePermissionTo('bypass users guard');
        $moderator->givePermissionTo('update shown_role');
        $moderator->givePermissionTo('bypass discussions guard');
        $moderator->givePermissionTo('create discussions');
        $moderator->givePermissionTo('restore posts');
        $moderator->givePermissionTo('read deleted posts');
        $moderator->givePermissionTo('update achievements');
        $moderator->givePermissionTo('ban users');
        $moderator->givePermissionTo('bypass throttle');
        $moderator->givePermissionTo('upload animated avatars');
        $moderator->givePermissionTo('sync discord emojis');

        $supporter->givePermissionTo('update shown_role');
        $supporter->givePermissionTo('create discussions');
        $supporter->givePermissionTo('read deleted posts');
        $supporter->givePermissionTo('upload animated avatars');
        $supporter->givePermissionTo('sync discord emojis');

        $user->givePermissionTo('create discussions');

        $verified->givePermissionTo('create discussions');
    }
}
