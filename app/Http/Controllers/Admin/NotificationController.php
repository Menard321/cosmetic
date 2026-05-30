<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $users = User::whereNotNull('phone')->get();
        // Mock notification history
        $history = [
            ['to' => '255747461380', 'message' => 'Welcome to Niffer Cosmetic!', 'status' => 'delivered', 'sent_at' => now()->subHours(2)],
            ['to' => '254712345678', 'message' => 'Your order #1023 is shipped.', 'status' => 'delivered', 'sent_at' => now()->subDay()],
        ];

        return view('admin.notifications.index', compact('users', 'history'));
    }

    public function sendCampaign(Request $request, SmsService $smsService)
    {
        $request->validate([
            'message' => 'required|string|max:160',
            'audience' => 'required|string',
        ]);

        $users = User::query();
        if ($request->audience !== 'all') {
            // Filter by branch or role as needed
        }

        $recipients = $users->whereNotNull('phone')->pluck('phone');
        $successCount = 0;

        foreach ($recipients as $phone) {
            $response = $smsService->sendSms($phone, $request->message);
            if ($response['success']) {
                $successCount++;
            }
        }

        return back()->with('status', "Campaign sent successfully to $successCount recipients!");
    }
}
