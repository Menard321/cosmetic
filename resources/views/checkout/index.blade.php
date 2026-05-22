@extends('layouts.master')

@section('content')
<section class="py-stack-lg bg-surface-container-low min-h-screen">
    <div class="px-margin-mobile md:px-margin-desktop max-w-[1200px] mx-auto">
        <h1 class="font-headline-md text-headline-md text-on-surface mb-stack-lg">Secure Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
                <!-- Shipping & Payment Info -->
                <div class="lg:col-span-12 xl:col-span-8 space-y-gutter">
                    <!-- Delivery Address -->
                    <div class="bg-white p-8 border border-outline-variant/20 shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">1</span>
                            <h2 class="font-label-md text-on-surface uppercase font-bold">Delivery Address</h2>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="label-premium block mb-2">Street Address / Region in Dar es Salaam</label>
                                <textarea name="address" rows="3" class="form-input-premium w-full" placeholder="e.g. Plot 42, Mikocheni B, Dar es Salaam" required></textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="label-premium block mb-2">Contact Name</label>
                                    <input type="text" class="form-input-premium w-full" value="{{ auth()->user()->name }}" required>
                                </div>
                                <div>
                                    <label class="label-premium block mb-2">Mobile Number (For Delivery)</label>
                                    <input type="text" name="phone_number" class="form-input-premium w-full" placeholder="+255..." required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white p-8 border border-outline-variant/20 shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">2</span>
                            <h2 class="font-label-md text-on-surface uppercase font-bold">Payment Method (Tanzania Specials)</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- M-Pesa -->
                            <label class="relative flex items-center p-4 border border-outline-variant/30 rounded-xl cursor-pointer hover:bg-surface-variant/10 transition-colors">
                                <input type="radio" name="payment_method" value="mpesa" class="w-4 h-4 text-primary focus:ring-primary" required>
                                <div class="ml-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center text-white font-bold text-xs">V</div>
                                    <span class="font-bold text-on-surface">Vodacom M-Pesa</span>
                                </div>
                            </label>

                            <!-- Tigo Pesa -->
                            <label class="relative flex items-center p-4 border border-outline-variant/30 rounded-xl cursor-pointer hover:bg-surface-variant/10 transition-colors">
                                <input type="radio" name="payment_method" value="tigopesa" class="w-4 h-4 text-primary focus:ring-primary">
                                <div class="ml-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-700 rounded flex items-center justify-center text-white font-bold text-xs">T</div>
                                    <span class="font-bold text-on-surface">Tigo Pesa</span>
                                </div>
                            </label>

                            <!-- Airtel Money -->
                            <label class="relative flex items-center p-4 border border-outline-variant/30 rounded-xl cursor-pointer hover:bg-surface-variant/10 transition-colors">
                                <input type="radio" name="payment_method" value="airtelmoney" class="w-4 h-4 text-primary focus:ring-primary">
                                <div class="ml-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-500 rounded flex items-center justify-center text-white font-bold text-xs">A</div>
                                    <span class="font-bold text-on-surface">Airtel Money</span>
                                </div>
                            </label>

                            <!-- Bank Account -->
                            <label class="relative flex items-center p-4 border border-outline-variant/30 rounded-xl cursor-pointer hover:bg-surface-variant/10 transition-colors">
                                <input type="radio" name="payment_method" value="bank" class="w-4 h-4 text-primary focus:ring-primary">
                                <div class="ml-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-on-background rounded flex items-center justify-center text-white">
                                        <span class="material-symbols-outlined text-sm">account_balance</span>
                                    </div>
                                    <span class="font-bold text-on-surface">TZ Local Bank (CRDB/NMB)</span>
                                </div>
                            </label>
                        </div>

                        <div class="mt-8 p-4 bg-primary-container/10 border border-primary-container/20 rounded-xl">
                            <p class="text-xs text-on-surface-variant leading-relaxed">
                                <span class="font-bold text-primary italic">Note:</span> After clicking "Place Order", you will receive the Lipa Namba and payment instructions on the order confirmation page. Delivery is prioritized for confirmed payments.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-12 xl:col-span-4">
                    <div class="bg-surface-container p-8 sticky top-24 border border-outline-variant/20 shadow-xl">
                        <h2 class="font-label-md text-on-surface uppercase font-bold border-b border-outline-variant pb-4 mb-6">Order Review</h2>
                        
                        <div class="max-h-60 overflow-y-auto mb-6 pr-2 space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between items-center gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-white border border-outline-variant/30 shrink-0 overflow-hidden">
                                            <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-on-surface line-clamp-1">{{ $item['name'] }}</p>
                                            <p class="text-[10px] text-on-surface-variant">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                    </div>
                                    <p class="text-xs font-bold text-on-surface whitespace-nowrap">{{ number_format($item['price'] * $item['quantity']) }} TZS</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 mb-8 pt-6 border-t border-outline-variant/20">
                            <div class="flex justify-between text-sm">
                                <span class="text-on-surface-variant">Subtotal</span>
                                <span class="font-bold text-on-surface">{{ number_format($subtotal) }} TZS</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-on-surface-variant">Shipping Fee (Dar)</span>
                                <span class="font-bold text-on-surface">{{ number_format($shipping) }} TZS</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-on-surface-variant">VAT (18%)</span>
                                <span class="font-bold text-on-surface">{{ number_format($vat) }} TZS</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-outline-variant pt-6 mb-8 flex justify-between items-baseline">
                            <span class="font-headline-sm text-headline-sm">Grand Total</span>
                            <span class="font-headline-sm text-headline-sm text-primary">{{ number_format($total) }} TZS</span>
                        </div>

                        <button type="submit" class="w-full bg-on-background text-white text-center py-5 font-label-md uppercase tracking-wider hover:bg-primary shadow-2xl transition-all duration-700">
                            Place Order & Pay
                        </button>

                        <div class="mt-6 flex items-center justify-center gap-4 opacity-40">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Secure TLS Encryption</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
