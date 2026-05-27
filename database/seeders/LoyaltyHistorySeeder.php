<?php

namespace Database\Seeders;

use App\Models\LoyaltyTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LoyaltyHistorySeeder extends Seeder
{
    public function run(): void
    {
        $targetIds = [6, 1, 2, 3, 4, 5];
        
        foreach ($targetIds as $userId) {
            $user = User::find($userId);
            if (!$user) continue;

            // Clear existing transactions to have a clean graph
            LoyaltyTransaction::where('user_id', $user->id)->delete();

            $pointsPool = [150, 450, 200, 800, 350, 600, 1200];
            
            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::now()->subDays(6 - $i);
                
                LoyaltyTransaction::create([
                    'user_id' => $user->id,
                    'points' => $pointsPool[$i],
                    'type' => 'earned',
                    'description' => "Purchase Rewards - " . $date->format('M d'),
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }

            // Add one redemption
            LoyaltyTransaction::create([
                'user_id' => $user->id,
                'points' => -500,
                'type' => 'redeemed',
                'description' => "Redeemed: Signature Matte Lipstick",
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1)
            ]);

            // Update user total
            $user->loyalty_points = LoyaltyTransaction::where('user_id', $user->id)->sum('points');
            $user->loyalty_level = $user->calculateLoyaltyLevel();
            $user->save();
        }
    }
}
