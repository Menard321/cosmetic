@extends('layouts.master')

@section('content')

{{-- Success / Error Flash --}}
@if(session('success'))
<div id="flash-success" class="fixed top-6 right-6 z-[9999] flex items-center gap-3 bg-on-background text-white px-6 py-4 shadow-2xl border-l-4 border-primary transition-all duration-500">
    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
    <p class="font-label-md">{{ session('success') }}</p>
    <button onclick="document.getElementById('flash-success').remove()" class="ml-4 text-white/60 hover:text-white">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
@endif

@if($errors->any())
<div id="flash-error" class="fixed top-6 right-6 z-[9999] flex items-start gap-3 bg-error text-white px-6 py-4 shadow-2xl border-l-4 border-error-container max-w-sm">
    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">error</span>
    <div>
        <p class="font-label-md font-bold mb-1">Please fix the errors below.</p>
        <ul class="text-sm text-white/80 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- Hero Banner --}}
<section class="relative h-[420px] w-full flex items-end overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img
            class="w-full h-full object-cover object-top"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9N9HQ9t5HVPfF4xP4wKWubZN4y5M9w_cMwSgmQ1g9LeVSBboMtEsugvhekq_NZeaYcFENbVqRUeWCQbVsiIwlRsqSTiCqHRBmEcI3yDtNNiqr-hXb5eX4L2ZA0IL0PJYeVdx3X5bSp4DZjEJWuExB9aSWPQaoqp9X0unLrOo8AlBq39k_US9espduUWRF_tZazC7yUtuahvQmZ2bhma7YMpR98tnp5Knbqb55lGagWlj58Yu8CL3G1Dy-swkF3V2h5k6Ao1O33g0"
            alt="Consultation Hero"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-on-background via-on-background/60 to-transparent"></div>
    </div>
    <div class="relative z-10 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full pb-12">
        <p class="font-label-sm text-primary uppercase tracking-[0.3em] mb-2">Personalized Care</p>
        <h1 class="font-display-lg text-display-lg text-white leading-tight max-w-2xl">
            Book Your Beauty <span class="text-primary italic">Consultation</span>
        </h1>
        <p class="font-body-lg text-white/70 mt-4 max-w-lg">
            Connect with our certified Tanzanian beauty consultants for a routine tailored entirely to your unique needs.
        </p>
    </div>
</section>

{{-- Booking Form Section --}}
<section class="bg-surface-container-low py-16 px-margin-mobile md:px-margin-desktop min-h-screen">
    <div class="max-w-4xl mx-auto">

        {{-- Progress Steps --}}
        <div class="flex items-center justify-center gap-0 mb-16">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-on-background text-white flex items-center justify-center font-bold text-sm shadow-lg">1</div>
                <p class="text-[10px] uppercase tracking-widest mt-2 text-on-surface font-bold">Your Details</p>
            </div>
            <div class="h-px w-24 bg-outline-variant mx-2 mt-[-20px]"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-primary-container/30 text-primary flex items-center justify-center font-bold text-sm border-2 border-primary">2</div>
                <p class="text-[10px] uppercase tracking-widest mt-2 text-primary font-bold">Skin Profile</p>
            </div>
            <div class="h-px w-24 bg-outline-variant mx-2 mt-[-20px]"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-surface-container-highest text-on-surface-variant flex items-center justify-center font-bold text-sm border border-outline-variant">3</div>
                <p class="text-[10px] uppercase tracking-widest mt-2 text-on-surface-variant">Confirm</p>
            </div>
        </div>

        <form action="{{ route('consultation.store') }}" method="POST" id="consultationForm">
            @csrf

            {{-- Card: Personal Information --}}
            <div class="bg-white border border-outline-variant/30 shadow-sm mb-8">
                <div class="px-8 py-6 border-b border-outline-variant/20 flex items-center gap-3">
                    <div class="w-8 h-8 bg-on-background rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">person</span>
                    </div>
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Personal Information</h2>
                        <p class="text-[11px] text-on-surface-variant uppercase tracking-wider">So we know who we're speaking with</p>
                    </div>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Full Name --}}
                    <div class="space-y-2">
                        <label for="name" class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">Full Name <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">badge</span>
                            <input
                                type="text" id="name" name="name"
                                value="{{ old('name', auth()->user()->name ?? '') }}"
                                placeholder="e.g. Amina Hassan"
                                class="w-full pl-12 pr-4 py-4 bg-surface-container-low border {{ $errors->has('name') ? 'border-error' : 'border-outline-variant' }} focus:outline-none focus:border-on-background transition-colors font-body-md text-on-surface"
                                required
                            />
                        </div>
                        @error('name') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label for="email" class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">Email Address <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">mail</span>
                            <input
                                type="email" id="email" name="email"
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                placeholder="you@example.com"
                                class="w-full pl-12 pr-4 py-4 bg-surface-container-low border {{ $errors->has('email') ? 'border-error' : 'border-outline-variant' }} focus:outline-none focus:border-on-background transition-colors font-body-md text-on-surface"
                                required
                            />
                        </div>
                        @error('email') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div class="space-y-2">
                        <label for="phone_number" class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">Phone Number <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">phone</span>
                            <input
                                type="tel" id="phone_number" name="phone_number"
                                value="{{ old('phone_number') }}"
                                placeholder="+255 7XX XXX XXX"
                                class="w-full pl-12 pr-4 py-4 bg-surface-container-low border {{ $errors->has('phone_number') ? 'border-error' : 'border-outline-variant' }} focus:outline-none focus:border-on-background transition-colors font-body-md text-on-surface"
                                required
                            />
                        </div>
                        @error('phone_number') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Empty col spacer on mobile --}}
                    <div class="hidden md:block"></div>
                </div>
            </div>

            {{-- Card: Appointment Preference --}}
            <div class="bg-white border border-outline-variant/30 shadow-sm mb-8">
                <div class="px-8 py-6 border-b border-outline-variant/20 flex items-center gap-3">
                    <div class="w-8 h-8 bg-on-background rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">calendar_month</span>
                    </div>
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Appointment Preference</h2>
                        <p class="text-[11px] text-on-surface-variant uppercase tracking-wider">Choose your ideal time slot</p>
                    </div>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Preferred Date --}}
                    <div class="space-y-2">
                        <label for="preferred_date" class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">Preferred Date <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">event</span>
                            <input
                                type="date" id="preferred_date" name="preferred_date"
                                value="{{ old('preferred_date') }}"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full pl-12 pr-4 py-4 bg-surface-container-low border {{ $errors->has('preferred_date') ? 'border-error' : 'border-outline-variant' }} focus:outline-none focus:border-on-background transition-colors font-body-md text-on-surface"
                                required
                            />
                        </div>
                        @error('preferred_date') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Preferred Time --}}
                    <div class="space-y-2">
                        <label for="preferred_time" class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">Preferred Time <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">schedule</span>
                            <select
                                id="preferred_time" name="preferred_time"
                                class="w-full pl-12 pr-4 py-4 bg-surface-container-low border {{ $errors->has('preferred_time') ? 'border-error' : 'border-outline-variant' }} focus:outline-none focus:border-on-background transition-colors font-body-md text-on-surface appearance-none"
                                required
                            >
                                <option value="" disabled {{ old('preferred_time') ? '' : 'selected' }}>-- Select a time slot --</option>
                                <option value="09:00 AM" {{ old('preferred_time') == '09:00 AM' ? 'selected' : '' }}>09:00 AM</option>
                                <option value="10:00 AM" {{ old('preferred_time') == '10:00 AM' ? 'selected' : '' }}>10:00 AM</option>
                                <option value="11:00 AM" {{ old('preferred_time') == '11:00 AM' ? 'selected' : '' }}>11:00 AM</option>
                                <option value="12:00 PM" {{ old('preferred_time') == '12:00 PM' ? 'selected' : '' }}>12:00 PM (Noon)</option>
                                <option value="02:00 PM" {{ old('preferred_time') == '02:00 PM' ? 'selected' : '' }}>02:00 PM</option>
                                <option value="03:00 PM" {{ old('preferred_time') == '03:00 PM' ? 'selected' : '' }}>03:00 PM</option>
                                <option value="04:00 PM" {{ old('preferred_time') == '04:00 PM' ? 'selected' : '' }}>04:00 PM</option>
                                <option value="05:00 PM" {{ old('preferred_time') == '05:00 PM' ? 'selected' : '' }}>05:00 PM</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline text-lg pointer-events-none">expand_more</span>
                        </div>
                        @error('preferred_time') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Card: Skin Profile --}}
            <div class="bg-white border border-outline-variant/30 shadow-sm mb-8">
                <div class="px-8 py-6 border-b border-outline-variant/20 flex items-center gap-3">
                    <div class="w-8 h-8 bg-on-background rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">face</span>
                    </div>
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Skin Profile</h2>
                        <p class="text-[11px] text-on-surface-variant uppercase tracking-wider">Help our experts prepare for your session</p>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    {{-- Skin Type --}}
                    <div class="space-y-3">
                        <label class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">Skin Type <span class="text-outline">(Optional)</span></label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach(['Oily', 'Dry', 'Combination', 'Sensitive'] as $type)
                            <label class="skin-type-option cursor-pointer">
                                <input type="radio" name="skin_type" value="{{ $type }}" class="sr-only" {{ old('skin_type') == $type ? 'checked' : '' }} />
                                <div class="skin-type-card border-2 border-outline-variant/50 p-4 text-center transition-all duration-200 hover:border-on-background {{ old('skin_type') == $type ? 'border-on-background bg-on-background text-white' : 'text-on-surface' }}">
                                    <span class="material-symbols-outlined text-2xl mb-2 block">
                                        @if($type == 'Oily') water_drop
                                        @elseif($type == 'Dry') thermostat
                                        @elseif($type == 'Combination') balance
                                        @else spa
                                        @endif
                                    </span>
                                    <p class="font-label-sm text-sm font-semibold">{{ $type }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Concerns --}}
                    <div class="space-y-2">
                        <label for="concerns" class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">Your Concerns <span class="text-outline">(Optional)</span></label>
                        <textarea
                            id="concerns" name="concerns"
                            rows="5"
                            placeholder="Tell us about your skin goals, current issues (e.g. hyperpigmentation, acne, dullness), products you currently use, or anything else you'd like to discuss with your consultant..."
                            class="w-full px-5 py-4 bg-surface-container-low border {{ $errors->has('concerns') ? 'border-error' : 'border-outline-variant' }} focus:outline-none focus:border-on-background transition-colors font-body-md text-on-surface resize-none"
                        >{{ old('concerns') }}</textarea>
                        @error('concerns') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Terms & Submit --}}
            <div class="bg-white border border-outline-variant/30 shadow-sm p-8">
                <div class="flex items-start gap-4 mb-8">
                    <input type="checkbox" id="terms" class="mt-1 w-4 h-4 accent-on-background" required />
                    <label for="terms" class="font-body-md text-on-surface-variant leading-relaxed">
                        I understand this is a <strong class="text-on-surface">booking request</strong> and that a Niffer Cosmetic consultant will confirm or reschedule my appointment via email or phone within 24 hours.
                    </label>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 items-center">
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-on-background text-white px-12 py-4 font-label-md uppercase tracking-widest hover:bg-primary transition-all duration-500 flex items-center justify-center gap-3 group">
                        <span class="material-symbols-outlined group-hover:rotate-12 transition-transform" style="font-variation-settings: 'FILL' 1;">send</span>
                        Submit Booking Request
                    </button>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto text-center border border-outline-variant text-on-surface-variant px-8 py-4 font-label-md uppercase tracking-widest hover:bg-surface-container transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- What to Expect Section --}}
<section class="py-16 bg-on-background text-white px-margin-mobile md:px-margin-desktop">
    <div class="max-w-container-max mx-auto">
        <h2 class="font-headline-md text-headline-md text-center mb-12">What Happens Next?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 border border-primary/50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">send</span>
                </div>
                <p class="font-label-md uppercase tracking-widest text-primary mb-2">Step 1</p>
                <h3 class="font-headline-sm mb-3">Submit Request</h3>
                <p class="text-white/60 font-body-md">Fill the form and submit your consultation request with your preferred time and skin concerns.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 border border-primary/50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">how_to_reg</span>
                </div>
                <p class="font-label-md uppercase tracking-widest text-primary mb-2">Step 2</p>
                <h3 class="font-headline-sm mb-3">Admin Review</h3>
                <p class="text-white/60 font-body-md">Our team will review your request and confirm the appointment within 24 hours.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 border border-primary/50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">spa</span>
                </div>
                <p class="font-label-md uppercase tracking-widest text-primary mb-2">Step 3</p>
                <h3 class="font-headline-sm mb-3">Your Session</h3>
                <p class="text-white/60 font-body-md">Meet your certified beauty consultant and receive a fully personalized skincare plan.</p>
            </div>
        </div>
    </div>
</section>

<style>
.skin-type-option input:checked + .skin-type-card {
    border-color: var(--color-on-background, #1a1a1a);
    background-color: var(--color-on-background, #1a1a1a);
    color: white;
}
.skin-type-option input:checked + .skin-type-card span,
.skin-type-option input:checked + .skin-type-card p {
    color: white;
}
</style>

<script>
// Skin type card selection
document.querySelectorAll('.skin-type-option input').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.skin-type-card').forEach(card => {
            card.style.borderColor = '';
            card.style.backgroundColor = '';
            card.style.color = '';
            card.querySelectorAll('*').forEach(el => el.style.color = '');
        });
    });
});

// Auto-dismiss flash
setTimeout(() => {
    const flash = document.getElementById('flash-success');
    if (flash) flash.style.opacity = '0', flash.style.transform = 'translateX(100%)', setTimeout(() => flash.remove(), 500);
}, 5000);

// Confirm before submit
document.getElementById('consultationForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span> Submitting...';
    btn.disabled = true;
});
</script>

@endsection
