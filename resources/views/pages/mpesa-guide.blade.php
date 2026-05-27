@extends('layouts.master')

@section('content')
<section class="py-24 bg-surface-container-low min-h-screen">
    <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop">
        <h1 class="text-5xl font-black text-on-surface mb-8">Payment Guide</h1>
        
        <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-surface-dim/20 space-y-12">
            
            <div class="flex items-start gap-6 border-b border-outline-variant/30 pb-10">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/M-Pesa_Logo.svg/1024px-M-Pesa_Logo.svg.png" class="h-12 w-auto object-contain">
                <div>
                    <h2 class="text-2xl font-bold text-on-surface mb-2">Automated M-Pesa STK Push</h2>
                    <p class="text-on-surface-variant mb-6">Our system uses the latest Mongike Direct API. You don't need to exit the app or dial any codes.</p>
                    
                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <span class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold shrink-0">1</span>
                            <p class="text-sm">Select **M-Pesa** at checkout and enter your Vodacom number.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold shrink-0">2</span>
                            <p class="text-sm">Wait for a professional **Payment Prompt** to appear automatically on your phone.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold shrink-0">3</span>
                            <p class="text-sm">Enter your **M-Pesa PIN** to authorize the luxury transaction.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold shrink-0">4</span>
                            <p class="text-sm">Your order status will update to **Paid** instantly.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-6 pt-2">
                <span class="material-symbols-outlined text-4xl text-primary">account_balance</span>
                <div>
                    <h2 class="text-2xl font-bold text-on-surface mb-2">Bank Transfers (CRDB/NMB)</h2>
                    <p class="text-on-surface-variant mb-4">For bulk or corporate beauty orders, we accept direct bank transfers.</p>
                    <div class="p-6 bg-surface-container rounded-2xl border border-outline-variant/30 text-sm">
                        <p class="font-bold mb-2">Angels Beauty Tanzania Ltd</p>
                        <p>Bank: CRDB Bank</p>
                        <p>Account: 015XXXXXXXXXXXX</p>
                        <p>CVV: 000</p>
                        <P>EXP: 00/00 </P>
                        <p>Currency: TZS / USD</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 p-6 bg-primary/5 rounded-3xl border border-primary/20 text-center">
                <p class="text-on-surface-variant text-sm italic">"Secure, Encrypted, and Reliable. Angels Beauty uses international payment gateway standards to protect every shilling."</p>
            </div>
        </div>
    </div>
</section>
@endsection
