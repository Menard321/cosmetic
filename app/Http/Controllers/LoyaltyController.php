<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyTransaction;
use App\Models\Reward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoyaltyController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user()->load(['tickets.event', 'referrals']);
        
        // 1. Point History Data (Select only necessary fields)
        $weeklyData = LoyaltyTransaction::where('user_id', $user->id)
            ->where('points', '>', 0)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'ASC')
            ->get();

        // 2. Redemption History
        $recentTransactions = LoyaltyTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();

        // 3. Available Rewards
        $availableRewards = Reward::where('is_active', true)->get();

        // 4. Calculate Tier Progress Logic
        $currentTier = $user->tier;
        $nextTier = \App\Models\LoyaltyTier::where('min_points', '>', $user->loyalty_points)
            ->orderBy('min_points', 'asc')
            ->first();

        $progress = 0;
        $pointsToNext = 0;

        if ($nextTier) {
            $pointsToNext = $nextTier->min_points - $user->loyalty_points;
            $range = $nextTier->min_points - ($currentTier->min_points ?? 0);
            $earnedInRange = $user->loyalty_points - ($currentTier->min_points ?? 0);
            $progress = min(100, ($earnedInRange / $range) * 100);
        } else {
            $progress = 100; // Max tier reached
        }

        // 5. Active Beauty Events
        $activeEvents = \App\Models\BeautyEvent::where('is_active', true)
            ->where('event_date', '>', now())
            ->get();

        return view('customer.loyalty', compact(
            'user', 
            'weeklyData', 
            'recentTransactions', 
            'availableRewards',
            'currentTier',
            'nextTier',
            'progress',
            'pointsToNext',
            'activeEvents'
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
    public function bookEvent(Request $request, \App\Models\BeautyEvent $event)
    {
        $user = auth()->user();

        // 1. Validation
        if ($event->tickets()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You have already booked a seat for this event!');
        }

        if ($event->tickets()->count() >= $event->capacity) {
            return back()->with('error', 'Sorry, this event is fully booked!');
        }

        if ($user->loyalty_points < $event->points_required) {
            return back()->with('error', 'Insufficient points to book this event!');
        }

        try {
            DB::beginTransaction();

            // 2. Deduct points if applicable
            if ($event->points_required > 0) {
                $user->loyalty_points -= $event->points_required;
                $user->save();

                LoyaltyTransaction::create([
                    'user_id' => $user->id,
                    'points' => -$event->points_required,
                    'type' => 'redeemed',
                    'description' => "Event Booking: " . $event->title
                ]);
            }

            // 3. Create Ticket
            \App\Models\EventTicket::create([
                'user_id' => $user->id,
                'beauty_event_id' => $event->id,
                'ticket_code' => 'EVT-' . strtoupper(Str::random(8)),
                'status' => 'active'
            ]);

            DB::commit();
            return back()->with('success', "Seat reserved successfully for {$event->title}!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }
}
