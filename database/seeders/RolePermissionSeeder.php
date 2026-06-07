<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'all',
            'view user',
            'manage users',
            'delete users',
            'view soa',
            'create/edit/delete soa',
            'view patients',
            'manage patients',
            'view report',
            'view settings',
            'manage settings',
            'export report',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $roles = [
            'admin',
            'vendor',
            'owner',
            'manager',
            'client',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $admin  = Role::where('name', 'admin')->first();
        $vendor = Role::where('name', 'vendor')->first();
        $owner  = Role::where('name', 'owner')->first();
        $manager = Role::where('name', 'manager')->first();
        $client = Role::where('name', 'client')->first();

        $admin->syncPermissions(Permission::all());

        $vendor->syncPermissions(
            Permission::whereIn('name', [
                'view patients',
                'manage patients',
                'view report',
                'view soa',
                'create/edit/delete soa',
            ])->get()
        );

        $owner->syncPermissions(
            Permission::whereIn('name', [
                'view patients',
                'manage patients',
                'view report',
                'view soa',
                'create/edit/delete soa',
            ])->get()
        );

        $manager->syncPermissions(
            Permission::whereIn('name', [
                'view patients',
                'view report',
            ])->get()
        );

        $client->syncPermissions(
            Permission::whereIn('name', [
                'view patients',
            ])->get()
        );
    }
}
