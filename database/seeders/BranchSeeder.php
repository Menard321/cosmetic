<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Niffer Mall Sinza',
                'slug' => 'sinza',
                'location' => 'Dar Es Salaam',
                'address' => 'Sinza Mori, Niffer Mall',
                'phone' => '+255 700 000 001',
                'is_active' => true,
            ],
            [
                'name' => 'Niffer Cosmetic Kigamboni',
                'slug' => 'kigamboni',
                'location' => 'Dar Es Salaam',
                'address' => 'Kigamboni Ferry, Near Tigo Shop',
                'phone' => '+255 700 000 002',
                'is_active' => true,
            ],
            [
                'name' => 'Niffer Cosmetic Dodoma',
                'slug' => 'dodoma',
                'location' => 'Dodoma',
                'address' => 'Area D, Dodoma Capital',
                'phone' => '+255 700 000 003',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            \App\Models\Branch::updateOrCreate(['slug' => $branch['slug']], $branch);
        }
    }
}
