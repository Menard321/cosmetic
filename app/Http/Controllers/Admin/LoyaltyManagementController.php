<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoyaltyManagementController extends Controller
{
    public function index()
    {
        // 1. Customer Lifetime Value (CLV) Average
        $avgCLV = \App\Models\User::role('customer')
            ->withSum('orders', 'total_amount')
            ->get()
            ->avg('orders_sum_total_amount');

        // 2. Redemption Rate
        $totalEarned = \App\Models\LoyaltyTransaction::where('points', '>', 0)->sum('points');
        $totalRedeemed = abs(\App\Models\LoyaltyTransaction::where('points', '<', 0)->sum('points'));
        $redemptionRate = $totalEarned > 0 ? ($totalRedeemed / $totalEarned) * 100 : 0;

        // 3. Branch Loyalty Performance
        $branches = \App\Models\Branch::withCount(['orders' => function($q) {
            $q->whereHas('user', function($u) {
                $u->where('loyalty_points', '>', 0);
            });
        }])->get();

        // 4. Recent Campaigns
        $activeCampaigns = \App\Models\LoyaltyCampaign::with('category')->where('is_active', true)->get();

        return view('admin.loyalty.index', compact(
            'avgCLV',
            'redemptionRate',
            'branches',
            'activeCampaigns',
            'totalEarned',
            'totalRedeemed'
        ));
    }

    public function redemptions()
    {
        $redemptions = \App\Models\LoyaltyTransaction::with('user')
            ->where('points', '<', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('admin.loyalty.redemptions', compact('redemptions'));
    }
}
