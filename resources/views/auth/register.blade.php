<x-guest-layout>
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-2 text-primary">
            <span class="material-symbols-outlined text-sm">person_add</span>
            <span class="text-[10px] uppercase font-bold tracking-[0.2em]">Membership Registration</span>
        </div>
        <h2 class="heading-font text-4xl text-on-surface mb-2">Join Silk Beauty</h2>
        <p class="text-on-surface-variant text-sm font-light">Register to access exclusive collections and tracking.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="label-premium">Legal Full Name</label>
            <div class="relative">
                <input id="name" class="form-input-premium pl-12" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="E.g. Amina Juma" />
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">badge</span>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-600" />
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="label-premium">Electronic Signature</label>
            <div class="relative">
                <input id="email" class="form-input-premium pl-12" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="exclusive@silkbeauty.tz" />
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">mail</span>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="label-premium">Choose Security Token</label>
            <div class="relative">
                <input id="password" class="form-input-premium pl-12"
                                type="password"
                                name="password"
                                required autocomplete="new-password" 
                                placeholder="••••••••" />
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">key</span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group mb-10">
            <label for="password_confirmation" class="label-premium">Verify Security Token</label>
            <div class="relative">
                <input id="password_confirmation" class="form-input-premium pl-12"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••" />
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">verified</span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-600" />
        </div>

        <button type="submit" class="auth-btn-primary mb-12">
            Initialize Membership
        </button>

        <div class="text-center pt-8 border-t border-outline-variant/30">
            <p class="text-[10px] text-on-surface-variant uppercase tracking-[0.2em] mb-4">Already authenticated?</p>
            <a href="{{ route('login') }}" class="text-xs font-bold text-on-surface underline decoration-primary underline-offset-8 decoration-2 hover:text-primary transition-all">
                Access Existing Account
            </a>
        </div>
    </form>
</x-guest-layout>
