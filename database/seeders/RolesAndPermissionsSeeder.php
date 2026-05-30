<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage users',
            'manage products',
            'manage orders',
            'manage inventory',
            'manage payments',
            'deliver orders',
            'vendor dashboard',
            'admin dashboard',
            'rider dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        
        // Super Admin gets everything
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Admin
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'manage users',
            'manage products',
            'manage orders',
            'manage inventory',
            'manage payments',
            'admin dashboard',
        ]);

        // Vendor
        $role = Role::create(['name' => 'vendor']);
        $role->givePermissionTo([
            'manage products',
            'manage orders',
            'vendor dashboard',
        ]);

        // Delivery Rider
        $role = Role::create(['name' => 'delivery-rider']);
        $role->givePermissionTo([
            'deliver orders',
            'rider dashboard',
        ]);

        // Branch Manager
        $role = Role::create(['name' => 'branch-manager']);
        $role->givePermissionTo([
            'manage orders',
            'manage inventory',
            'admin dashboard',
        ]);

        // Customer
        $role = Role::create(['name' => 'customer']);
        // Customers might not need specific permissions for standard web routes, 
        // but we can add them here if needed e.g., 'place orders'
    }
}
