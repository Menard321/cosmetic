<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\LoyaltyTier;
use App\Models\LoyaltyCampaign;
use App\Models\LoyaltyTransaction;

class LoyaltyService
{
    /**
     * Calculate points for a given order based on product categories and active campaigns.
     */
    public function calculatePoints(Order $order)
    {
        $totalPoints = 0;
        $order->load('items.product');

        foreach ($order->items as $item) {
            $basePoints = floor($item->price * $item->quantity / 1000); // 1 point per 1000 TZS
            
            // Check for active campaigns for this product's category
            $multiplier = 1.0;
            $campaign = LoyaltyCampaign::active()
                ->where('category_id', $item->product->category_id)
                ->first();
            
            if ($campaign) {
                $multiplier = $campaign->multiplier;
            }

            $totalPoints += floor($basePoints * $multiplier);
        }

        return $totalPoints;
    }

    /**
     * Award points to a user and update their tier.
     */
    public function awardPoints(User $user, int $points, string $description, int $orderId = null)
    {
        LoyaltyTransaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'points' => $points,
            'type' => 'earned',
            'description' => $description
        ]);

        $user->increment('loyalty_points', $points);
        $this->updateUserTier($user);
    }

    /**
     * Update user's loyalty tier based on cumulative points.
     */
    public function updateUserTier(User $user)
    {
        $currentPoints = $user->loyalty_points;
        
        $tier = LoyaltyTier::where('min_points', '<=', $currentPoints)
            ->orderBy('min_points', 'desc')
            ->first();

        if ($tier && $user->loyalty_level !== $tier->name) {
            $user->update([
                'loyalty_level' => $tier->name
            ]);
        }
    }

    /**
     * Process referral reward.
     */
    public function processReferral(User $referrer, User $referredUser)
    {
        $bonusPoints = 500; // Flat referral bonus
        
        $this->awardPoints($referrer, $bonusPoints, "Referral bonus for inviting {$referredUser->name}");
        
        // Also give the new user a small welcome bonus
        $this->awardPoints($referredUser, 100, "Welcome bonus for joining via referral");
    }
}
