<x-guest-layout>
    <div class="mb-8">
        <h2 class="heading-font text-2xl font-bold text-gray-800">Security Check</h2>
        <p class="text-gray-500 text-sm mt-1">We've sent a 6-digit code to your email.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verify.store') }}">
        @csrf

        <div class="mb-8">
            <label for="two_factor_code" class="label-premium">Verification Code</label>
            <input id="two_factor_code" class="form-input-premium text-center text-2xl tracking-[0.5em] font-bold" 
                   type="text" name="two_factor_code" 
                   :value="old('two_factor_code', $code)" 
                   required autofocus autocomplete="one-time-code" 
                   placeholder="000000" />
            <x-input-error :messages="$errors->get('two_factor_code')" class="mt-2" />
        </div>

        <button type="submit" class="auth-btn-primary mb-6">
            Verify Identity
        </button>

        <div class="text-center">
            <p class="text-xs text-gray-500 mb-2">Didn't receive the code?</p>
            <a class="text-sm text-pink-700 hover:text-pink-900 font-bold" href="{{ route('verify.resend') }}">
                Resend Code
            </a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('two_factor_code');
            const form = codeInput.closest('form');
            
            // Auto-submit if code is pre-filled and valid length
            if (codeInput.value.length === 6) {
                setTimeout(() => {
                    form.submit();
                }, 500); // Small delay for visual feedback
            }
        });
    </script>
</x-guest-layout>
