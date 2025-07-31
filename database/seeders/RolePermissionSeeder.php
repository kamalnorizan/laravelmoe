<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $pentadbirSekolah = Role::create(['name' => 'pentadbir sekolah', 'guard_name' => 'web']);
        $cikgu = Role::create(['name' => 'cikgu', 'guard_name' => 'web']);
        $ppd = Role::create(['name' => 'ppd', 'guard_name' => 'web']);

        Permission::create(['name' => 'view users', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit users', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete users', 'guard_name' => 'web']);
        Permission::create(['name' => 'create users', 'guard_name' => 'web']);

        Permission::create(['name' => 'view sekolah', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit sekolah', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete sekolah', 'guard_name' => 'web']);
        Permission::create(['name' => 'create sekolah', 'guard_name' => 'web']);

        $admin->givePermissionTo(['view users', 'edit users', 'delete users', 'create users', 'view sekolah', 'edit sekolah', 'delete sekolah', 'create sekolah']);
        $pentadbirSekolah->givePermissionTo(['view sekolah', 'edit sekolah', 'delete sekolah', 'create sekolah']);
        $cikgu->givePermissionTo(['view sekolah']);
        $ppd->givePermissionTo(['view sekolah', 'edit sekolah', 'view users', 'edit users']);
    }
}
