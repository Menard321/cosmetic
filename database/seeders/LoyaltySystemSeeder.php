<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoyaltySystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tiers
        \App\Models\LoyaltyTier::create([
            'name' => 'Silver',
            'min_points' => 0,
            'discount_percentage' => 0,
            'color_hex' => '#C0C0C0',
            'perks' => ['Basic beauty advice', 'Monthly newsletter']
        ]);

        \App\Models\LoyaltyTier::create([
            'name' => 'Gold',
            'min_points' => 1000,
            'discount_percentage' => 5,
            'color_hex' => '#FFD700',
            'perks' => ['Early access to sales', '5% discount on all items', 'Birthday gift']
        ]);

        \App\Models\LoyaltyTier::create([
            'name' => 'Platinum',
            'min_points' => 5000,
            'discount_percentage' => 10,
            'color_hex' => '#E5E4E2',
            'perks' => ['Free home delivery', '10% discount on all items', 'VIP beauty workshops']
        ]);

        \App\Models\LoyaltyTier::create([
            'name' => 'Diamond',
            'min_points' => 10000,
            'discount_percentage' => 15,
            'color_hex' => '#B9F2FF',
            'perks' => ['Personal beauty consultant', '15% discount on all items', 'Invitation to private launch events']
        ]);

        // Sample Campaign: 2x points on Skincare for the next 30 days
        $skincare = \App\Models\Category::where('name', 'Skincare')->first();
        if ($skincare) {
            \App\Models\LoyaltyCampaign::create([
                'name' => 'Skincare Radiance Month',
                'category_id' => $skincare->id,
                'multiplier' => 2.0,
                'starts_at' => now(),
                'ends_at' => now()->addDays(30),
                'is_active' => true
            ]);
        }
    }
}
