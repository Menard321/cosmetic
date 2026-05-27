@extends('layouts.master')

@section('content')
<section class="py-24 bg-surface-container-low min-h-screen">
    <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="bg-white p-12 rounded-[3rem] shadow-xl space-y-10">
            <h1 class="text-4xl font-black mb-8">{{ $title }}</h1>
            <div class="prose prose-pink max-w-none text-on-surface-variant leading-loose">
                <p class="mb-6 font-bold text-primary">Last Updated: May 2026</p>
                
                <h2 class="text-xl font-black uppercase text-on-surface mt-8 mb-4">1. Information We Collect</h2>
                <p>At Angels Beauty Tanzania, we prioritize your luxury experience and your privacy. We collect only necessary information to process your beauty orders, including name, shipping address, and phone number for delivery.</p>

                <h2 class="text-xl font-black uppercase text-on-surface mt-8 mb-4">2. Security Standards</h2>
                <p>Your transactional data is protected using TSL/SSL encryption. We do not store your M-Pesa or Bank PIN numbers on our servers. All payments are processed through secure gateways like Mongike.</p>

                <h2 class="text-xl font-black uppercase text-on-surface mt-8 mb-4">3. Returns & Refunds</h2>
                <p>Due to health and hygiene standards, cosmetic products can only be returned if the safety seal is intact and the product is in its original luxury packaging. Returns must be initiated within 48 hours of delivery.</p>

                <h2 class="text-xl font-black uppercase text-on-surface mt-8 mb-4">4. International Compliance</h2>
                <p>Our policies align with international data protection standards and the consumer protection laws of the United Republic of Tanzania.</p>
            </div>
            
            <div class="pt-10 border-t border-outline-variant/30 text-center">
                 <p class="text-sm italic">For further inquiries, please <a href="{{ route('pages.contact') }}" class="text-primary font-bold">Contact Our Legal Team</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
