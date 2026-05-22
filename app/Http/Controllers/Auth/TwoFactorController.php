<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function index()
    {
        $code = auth()->user()->two_factor_code;
        return view('auth.two_factor', compact('code'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|integer',
        ]);

        $user = auth()->user();

        if ($request->input('two_factor_code') === (string)$user->two_factor_code && $user->two_factor_expires_at->isFuture()) {
            $user->resetTwoFactorCode();
            
            return redirect()->intended(route('home'));
        }

        return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code you have entered is invalid or expired.']);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();

        Mail::to($user->email)->send(new TwoFactorCodeMail($user->two_factor_code));

        return redirect()->back()->withStatus('The two factor code has been sent again');
    }
}
