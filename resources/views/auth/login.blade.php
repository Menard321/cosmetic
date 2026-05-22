<x-guest-layout>
    <style>
        /* Override guest layout grid for centered card feel */
        .auth-grid { display: block !important; }
        .auth-image-side { display: none !important; }
        .auth-form-side { 
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/cosmetic_auth_split_bg_1779205834623.png') !important;
            background-size: cover !important;
            background-position: center !important;
            min-height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            padding: 48px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-width: 460px !important;
            margin: auto;
        }
        .auth-btn-primary {
            background: linear-gradient(135deg, #735c00 0%, #a68c36 100%);
            border-radius: 4px;
        }
    </style>

    <div class="text-center mb-10">
        <h2 class="heading-font text-3xl text-on-surface mb-2">Member Login</h2>
        <p class="text-on-surface-variant text-[10px] uppercase font-bold tracking-[0.3em]">Secure Gateway Access</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[10px] uppercase font-bold tracking-widest text-gray-500">Registered Email</label>
            <div class="relative">
                <input id="email" class="w-full bg-gray-50 border border-gray-200 p-3 pl-10 text-sm focus:border-primary focus:ring-0 outline-none transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@email.com" />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">mail</span>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <label for="password" class="text-[10px] uppercase font-bold tracking-widest text-gray-500">Security Key</label>
                @if (Route::has('password.request'))
                    <a class="text-[9px] text-primary font-bold uppercase tracking-widest hover:underline" href="{{ route('password.request') }}">
                        Reset
                    </a>
                @endif
            </div>
            <div class="relative">
                <input id="password" class="w-full bg-gray-50 border border-gray-200 p-3 pl-10 text-sm focus:border-primary focus:ring-0 outline-none transition-all"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">lock</span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="w-3 h-3 text-primary border-gray-300 focus:ring-0" name="remember">
            <label for="remember_me" class="ml-3 text-[10px] text-on-surface-variant uppercase tracking-widest cursor-pointer">Stay Signed In</label>
        </div>

        <button type="submit" class="auth-btn-primary">
            Authenticate & Enter
        </button>

        <div class="pt-8 border-t border-gray-100 text-center">
            <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-4">New to Silk Beauty?</p>
            <a href="{{ route('register') }}" class="text-xs font-bold text-gray-900 border-b-2 border-primary pb-1 hover:text-primary transition-all">
                CREATE MEMBERSHIP
            </a>
        </div>
    </form>
</x-guest-layout>
