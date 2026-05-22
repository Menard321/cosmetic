<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'super-admin',
            'customer',
            'vendor',
            'delivery-rider',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
        
        // Aliasing 'user' to 'customer' if it exists or for backward compatibility
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
    }
}
