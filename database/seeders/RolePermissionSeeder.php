<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::create(['name'=>'create posts']);
        Permission::create(['name'=>'edit posts']);
        Permission::create(['name'=>'delete posts']);
        Permission::create(['name'=>'publish posts']);
        Permission::create(['name'=>'approve comments']);
        Permission::create(['name'=>'delete comments']);
        Permission::create(['name'=>'manage users']);
        Permission::create(['name'=>'access admin']);

        $admin=Role::create(['name'=>'admin']);
        $author=Role::create(['name'=>'author']);
        $user=Role::create(['name'=>'user']);

        $admin->givePermissionTo(Permission::all());

        $author->givePermissionTo([
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts'
        ]);
        $user->givePermissionTo(['create posts']);


    }
}
