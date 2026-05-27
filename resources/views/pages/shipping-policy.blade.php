@extends('layouts.master')

@section('content')
<section class="py-24 bg-surface-container-low min-h-screen">
    <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop">
        <h1 class="text-5xl font-black text-on-surface mb-8">Shipping & Delivery</h1>
        
        <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-surface-dim/20 space-y-10 leading-relaxed">
            <section>
                <h2 class="text-2xl font-bold text-primary mb-4">International Standards, Local Excellence</h2>
                <p class="text-on-surface-variant">At Silk Beauty, we understand that your skincare and beauty needs are urgent. We maintain a professional logistics network across Tanzania and selected East African regions to ensure your luxury products arrive in perfect condition.</p>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-6 bg-surface-container rounded-3xl border border-outline-variant/30">
                    <h3 class="font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                        Dar es Salaam
                    </h3>
                    <p class="text-sm text-on-surface-variant">Same-day delivery for orders placed before 12:00 PM. Flat rate: 15,000 TZS.</p>
                </div>
                <div class="p-6 bg-surface-container rounded-3xl border border-outline-variant/30">
                    <h3 class="font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">distance</span>
                        Upcountry Tanzania
                    </h3>
                    <p class="text-sm text-on-surface-variant">Delivery within 48-72 hours via our professional courier partners. Rates vary by weight.</p>
                </div>
            </div>

            <section>
                <h2 class="text-2xl font-bold text-primary mb-4">Real-Time Tracking</h2>
                <p class="text-on-surface-variant mb-4">Every order once dispatched will receive a professional tracking number. You can monitor your delivery status directly through our integrated GPS tracking system.</p>
                <a href="{{ route('pages.track-order') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-on-background text-white rounded-full font-bold hover:bg-primary transition-all">
                    Track Your Bag
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </section>

            <section class="pt-8 border-t border-outline-variant/30">
                <h2 class="text-2xl font-bold text-primary mb-4">Packaging & Quality</h2>
                <p class="text-on-surface-variant">All Silk Beauty products are packed in eco-friendly, temperature-controlled luxury boxes to preserve the integrity of skincare and fragrance formulas during transit.</p>
            </section>
        </div>
    </div>
</section>
@endsection
