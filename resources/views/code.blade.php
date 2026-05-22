@extends('layouts.master')

@section('content')
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-lg min-h-screen">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
<!-- Main Content Area -->
<div class="lg:col-span-8">
<div class="flex flex-col gap-stack-lg">
<!-- Progress Step (Implicit) -->
<div class="flex items-center gap-stack-sm text-label-md font-label-md uppercase tracking-widest text-outline">
<span class="text-on-surface">Checkout</span>
<span class="material-symbols-outlined text-label-sm">chevron_right</span>
<span>Shipping</span>
<span class="material-symbols-outlined text-label-sm">chevron_right</span>
<span>Payment</span>
</div>
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-background">Secure Checkout</h1>
<!-- Shipping Section -->
<section class="bg-white p-stack-md md:p-stack-lg rounded-xl shadow-sm border border-outline-variant/10">
<div class="flex items-center justify-between mb-stack-md">
<h2 class="font-headline-sm text-headline-sm text-primary">Shipping Details</h2>
<span class="material-symbols-outlined text-primary" data-icon="local_shipping">local_shipping</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
<div class="flex flex-col gap-1">
<label class="text-label-sm font-label-sm text-outline px-1">Full Name</label>
<input class="border-b border-outline-variant focus:border-primary outline-none py-2 bg-transparent font-body-md text-on-surface" placeholder="Amani Hassan" type="text"/>
</div>
<div class="flex flex-col gap-1">
<label class="text-label-sm font-label-sm text-outline px-1">Phone Number (M-Pesa/Tigo Pesa)</label>
<input class="border-b border-outline-variant focus:border-primary outline-none py-2 bg-transparent font-body-md text-on-surface" placeholder="+255 7XX XXX XXX" type="tel"/>
</div>
<div class="flex flex-col gap-1 md:col-span-2">
<label class="text-label-sm font-label-sm text-outline px-1">Delivery Region</label>
<select class="border-b border-outline-variant focus:border-primary outline-none py-2 bg-transparent font-body-md text-on-surface appearance-none">
<option>Dar es Salaam</option>
<option>Arusha</option>
<option>Mwanza</option>
<option>Dodoma</option>
<option>Zanzibar</option>
</select>
</div>
<div class="flex flex-col gap-1 md:col-span-2">
<label class="text-label-sm font-label-sm text-outline px-1">Apartment, Suite, Landmark</label>
<input class="border-b border-outline-variant focus:border-primary outline-none py-2 bg-transparent font-body-md text-on-surface" placeholder="Near Posta, Samora Avenue" type="text"/>
</div>
</div>
</section>
<!-- Payment Method Section -->
<section class="bg-white p-stack-md md:p-stack-lg rounded-xl shadow-sm border border-outline-variant/10">
<div class="flex items-center justify-between mb-stack-md">
<h2 class="font-headline-sm text-headline-sm text-primary">Payment Method</h2>
<div class="flex items-center gap-2 px-3 py-1 bg-surface-container-low rounded-full">
<span class="material-symbols-outlined text-label-sm text-primary" data-weight="fill">verified_user</span>
<span class="text-label-sm font-label-sm text-on-surface-variant">SSL SECURED</span>
</div>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
<!-- M-Pesa -->
<button class="flex flex-col items-center justify-center gap-3 p-4 border-2 border-primary bg-primary-container/10 rounded-xl transition-all active:scale-95 group">
<div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center overflow-hidden">
<img alt="M-Pesa" class="w-8 h-8 object-contain" data-alt="Close up high-fidelity logo of M-Pesa mobile money service, presented on a clean white circular background. The visual style is minimalist and high-end, reflecting a premium fintech experience within a luxury Tanzanian skincare store. Soft ambient lighting illuminates the logo, giving it a tactile, professional quality consistent with a high-fashion digital interface." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCOgEuLOLMFzqv4pK8bufzI8yd3oqyl0gfE4y_aNIJy9bSEcZlI8Ozga8jTEUhYR9rTrSEVwFofcIJJRWWN3NGP3_juJXu4i7-Tyxx--qb3UBOrYiRwXgfwD3Zi2R_BDFfwvdHyhIdYzV716xvimLmqYkTXQXv2MW1qavikOgVWhmzl307FSZwf-QBSWS0AepmSfIickfVqjhMDn_4AMwxFr3aRsXQOhiitZ69MsZUUg0BQ8bb_Dj_PX1yfcxYmNOrF3TJ4WNEZWyg"/>
</div>
<span class="font-label-md text-label-md text-primary font-bold">M-Pesa</span>
<div class="w-4 h-4 rounded-full border-2 border-primary bg-primary flex items-center justify-center">
<div class="w-2 h-2 rounded-full bg-white"></div>
</div>
</button>
<!-- Tigo Pesa -->
<button class="flex flex-col items-center justify-center gap-3 p-4 border border-outline-variant hover:border-primary transition-all active:scale-95 group">
<div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center overflow-hidden">
<img alt="Tigo Pesa" class="w-8 h-8 object-contain" data-alt="High-resolution Tigo mobile money service logo displayed on a pristine white circular emblem. The aesthetic is clean and modern, set against a sophisticated luxury backdrop of soft champagne and silk textures. The lighting is bright and editorial, making the logo pop as a professional payment choice in an upscale Tanzanian boutique environment." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDozw8fEBenETMZG7sLjJeNgEnaEwv0N2kyGQ1qxzvYzuveXqXgHWVIxIuEfXDKmQgTJss4ilijELLRbfYaxFkj8eMyodCqYdKYGEAWKtMFSv8J58bP8MPEimnu5YJiwaQkGICHATZhp5nxOXAM-b0V7o3l1Mqg9gbj9tpZoAh4Z74oqh7lH7EBZYO85iwZpkparaangO8EdzhHIxG6uPDtQtj9w9mOShRsKIUjsStcNfv-aKZ1LPOdm-ArftNowfbJ8xoYfRtonY8"/>
</div>
<span class="font-label-md text-label-md text-on-surface-variant">Tigo Pesa</span>
<div class="w-4 h-4 rounded-full border border-outline-variant"></div>
</button>
<!-- Airtel Money -->
<button class="flex flex-col items-center justify-center gap-3 p-4 border border-outline-variant hover:border-primary transition-all active:scale-95 group">
<div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center overflow-hidden">
<img alt="Airtel Money" class="w-8 h-8 object-contain" data-alt="Close-up of the Airtel Money logo inside a soft white circle, designed with a premium, sleek aesthetic. The image captures the vibrant red of the brand against a minimalist, high-key studio setting. The lighting is soft and diffused, creating an atmosphere of exclusivity and reliable digital transactions for a luxury African ecommerce brand." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB---v7HiDIdL-4fRnxNeQX5UrzU6Czme9yhkPMGQkdz6pOn4kKUfwqS9hEtsSuWpm8O2UQqM0ufHfSqAiIo0OugzPOSp16aF6N05Ee4dnv91wO3hQV9U_wKWiRivEOIzs7J4grUOVGjnP9yPK6fqnHpi4nLW7gy2Kt04bxdm8X5a2kCI6I8yBb7eT6G7ECH4u2vIjQS9Ei9KvplqWt7QNIpH-YFzFEW2G9q5R1A6wHZ2Twt_39DU7AK8NlejSSHzkFuiz7vJE7f4M"/>
</div>
<span class="font-label-md text-label-md text-on-surface-variant">Airtel Money</span>
<div class="w-4 h-4 rounded-full border border-outline-variant"></div>
</button>
<!-- Visa / Card -->
<button class="flex flex-col items-center justify-center gap-3 p-4 border border-outline-variant hover:border-primary transition-all active:scale-95 group">
<div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center overflow-hidden">
<span class="material-symbols-outlined text-secondary text-3xl" data-icon="credit_card">credit_card</span>
</div>
<span class="font-label-md text-label-md text-on-surface-variant">Card / Visa</span>
<div class="w-4 h-4 rounded-full border border-outline-variant"></div>
</button>
</div>
<!-- Mobile Money Guide -->
<div class="mt-stack-md p-stack-sm bg-surface-container-low rounded-lg border border-outline-variant/20 flex items-start gap-3">
<span class="material-symbols-outlined text-primary mt-0.5" data-icon="info">info</span>
<div class="flex flex-col">
<p class="text-label-md font-label-md text-on-surface">M-Pesa Payment Guide</p>
<p class="text-label-sm font-label-sm text-secondary">A prompt will be sent to your phone. Enter your PIN to complete the transaction.</p>
</div>
</div>
</section>
</div>
</div>
<!-- Order Summary Sidebar -->
<aside class="lg:col-span-4">
<div class="bg-white p-stack-md md:p-stack-lg rounded-xl shadow-sm border border-outline-variant/10 sticky top-[100px]">
<h2 class="font-headline-sm text-headline-sm text-on-background mb-stack-md">Order Summary</h2>
<!-- Cart Items -->
<div class="flex flex-col gap-4 mb-stack-md border-b border-outline-variant pb-stack-md">
@foreach($cartItems as $item)
<div class="flex gap-4">
<div class="w-16 h-20 bg-surface-container-high rounded overflow-hidden flex-shrink-0">
<img alt="{{ $item->name }}" class="w-full h-full object-cover" data-alt="{{ $item->name }}" src="{{ $item->image_url }}"/>
</div>
<div class="flex flex-col justify-center flex-grow">
<p class="text-label-md font-label-md text-on-surface">{{ $item->name }}</p>
<p class="text-label-sm font-label-sm text-outline">{{ $item->brand }} • Qty: 1</p>
<p class="text-label-md font-label-md text-primary mt-1">{{ number_format($item->price) }} TZS</p>
</div>
</div>
@endforeach
</div>
<!-- Pricing Details -->
<div class="flex flex-col gap-stack-sm mb-stack-md">
<div class="flex justify-between">
<span class="text-body-md text-secondary">Subtotal</span>
<span class="text-body-md text-on-surface">{{ number_format($subtotal) }} TZS</span>
</div>
<div class="flex justify-between">
<span class="text-body-md text-secondary">Shipping (Standard)</span>
<span class="text-body-md text-on-surface">{{ number_format($shipping) }} TZS</span>
</div>
<div class="flex justify-between">
<span class="text-body-md text-secondary">Vat (18%)</span>
<span class="text-body-md text-on-surface">{{ number_format($vat) }} TZS</span>
</div>
</div>
<div class="flex justify-between items-center border-t border-outline-variant pt-stack-md mb-stack-lg">
<span class="font-headline-sm text-headline-sm text-on-background">Total</span>
<span class="font-headline-sm text-headline-sm text-primary">{{ number_format($total) }} TZS</span>
</div>
<!-- Action Button -->
<button class="w-full bg-on-background text-white py-4 rounded-xl font-label-md text-label-md uppercase tracking-widest hover:opacity-90 active:scale-95 transition-all flex items-center justify-center gap-2">
<span>Place Order Now</span>
<span class="material-symbols-outlined" data-icon="lock">lock</span>
</button>
<div class="mt-stack-md flex items-center justify-center gap-stack-sm text-outline">
<span class="material-symbols-outlined text-sm" data-icon="shield">shield</span>
<span class="text-label-sm font-label-sm">Secure Payment Guarantee</span>
</div>
</div>
</aside>
</div>
</div>
@endsection