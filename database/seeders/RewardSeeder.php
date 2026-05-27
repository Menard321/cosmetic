<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        Reward::create([
            'name' => 'Signature Matte Lipstick',
            'points_required' => 500,
            'description' => 'Redeem your points for our best-selling velvet matte lipstick.',
            'image' => null,
            'is_active' => true
        ]);

        Reward::create([
            'name' => 'Hydrating Glow Lotion',
            'points_required' => 1000,
            'description' => 'A luxury hydrating lotion for a perfect 24h glow.',
            'image' => null,
            'is_active' => true
        ]);

        Reward::create([
            'name' => 'Complete Makeup Kit',
            'points_required' => 5000,
            'description' => 'The ultimate Tynorosa collection for beauty enthusiasts.',
            'image' => null,
            'is_active' => true
        ]);

        Reward::create([
            'name' => 'VIP Spa Day Voucher',
            'points_required' => 10000,
            'description' => 'A full day of pampering at our exclusive partner spas.',
            'image' => null,
            'is_active' => true
        ]);
    }
}
