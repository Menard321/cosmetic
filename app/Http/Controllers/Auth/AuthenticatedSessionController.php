<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();
        
        // Auto-assign admin role exclusively to menard joseph
        if (strtolower($user->email) === 'menardjoseph23@gmail.com') {
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
            }
            return redirect()->route('admin.page');
        }

        // Revoke admin rights from anyone else who might have them
        if ($user->hasRole('admin')) {
            $user->removeRole('admin');
        }
        if ($user->hasRole('super-admin')) {
            $user->removeRole('super-admin');
        }

        return redirect()->intended(route('home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
