<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyTransaction;
use App\Models\Reward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoyaltyController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // 1. Weekly Points Growth Data
        $weeklyData = LoyaltyTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(points) as total_points'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 2. Redemption History
        $recentTransactions = LoyaltyTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();

        // 3. Available Rewards
        $availableRewards = Reward::where('is_active', true)->get();

        // 4. Calculate Progress to Next Level
        $levels = [
            'Bronze' => ['min' => 0, 'max' => 999, 'next' => 'Silver'],
            'Silver' => ['min' => 1000, 'max' => 4999, 'next' => 'Gold'],
            'Gold' => ['min' => 5000, 'max' => 9999, 'next' => 'Platinum'],
            'Platinum' => ['min' => 10000, 'max' => 999999, 'next' => 'Max Level'],
        ];

        $currentLevelInfo = $levels[$user->loyalty_level] ?? $levels['Bronze'];
        $nextLevelPoints = $currentLevelInfo['max'] + 1;
        $progress = min(100, ($user->loyalty_points / $nextLevelPoints) * 100);

        return view('customer.loyalty', compact(
            'user', 
            'weeklyData', 
            'recentTransactions', 
            'availableRewards',
            'currentLevelInfo',
            'progress',
            'nextLevelPoints'
        ));
    }

    public function redeem(Reward $reward)
    {
        $user = auth()->user();

        if ($user->loyalty_points < $reward->points_required) {
            return back()->with('error', 'Insufficient points to redeem this reward!');
        }

        try {
            DB::beginTransaction();

            $user->loyalty_points -= $reward->points_required;
            $user->save();

            LoyaltyTransaction::create([
                'user_id' => $user->id,
                'points' => -$reward->points_required,
                'type' => 'redeemed',
                'description' => "Redeemed: " . $reward->name
            ]);

            DB::commit();
            return back()->with('success', "Success! You have redeemed {$reward->name}. Check your email for the voucher code.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Redemption failed: ' . $e->getMessage());
        }
    }
}
