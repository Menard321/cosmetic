<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use App\Services\SmsService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request, SmsService $smsService): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'min:10', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('customer');

        // Process Referral if present
        if ($request->has('ref')) {
            $referrer = User::find($request->ref);
            if ($referrer && $referrer->id !== $user->id) {
                \App\Models\Referral::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                    'status' => 'completed',
                    'points_awarded' => 500,
                ]);

                $loyaltyService = app(\App\Services\LoyaltyService::class);
                $loyaltyService->processReferral($referrer, $user);
            }
        }

        // Send Welcome SMS using the phone number from the request
        $welcomeMessage = "Welcome to Niffer Cosmetic, {$user->name}! Thank you for registering with us. We look forward to serving your beauty needs.";
        $smsService->sendSms($request->phone, $welcomeMessage);

        event(new Registered($user));

        // Redirect back to login form instead of auto-logging in
        return redirect(route('login'))->with('status', 'Registration successful! Please log in with your new account.');
    }
}
