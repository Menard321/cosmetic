@extends('layouts.master')

@section('content')
<section class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-[80vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-on-background">
             <img src="https://images.unsplash.com/photo-1596462502278-27bfaf433394?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-60">
        </div>
        <div class="relative text-center px-6">
            <h1 class="font-display-lg text-white text-6xl md:text-8xl mb-6">Niffer Cosmetic</h1>
            <p class="text-primary tracking-[0.4em] uppercase font-bold text-lg">Excellence in Every Glow</p>
        </div>
    </div>

    <!-- Story Content -->
    <div class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop space-y-24">
            
            <div class="text-center">
                <h2 class="text-4xl font-headline-md mb-8">The Tanzanian Heritage</h2>
                <p class="text-xl text-on-surface-variant leading-relaxed font-body-lg italic">
                    "Niffer Cosmetic was born from a simple realization: Tanzanian women deserve world-class skincare that respects their skin's unique needs and the vibrant spirit of our nation."
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <h3 class="text-2xl font-bold uppercase tracking-widest text-primary">Our Vision</h3>
                    <p class="text-on-surface-variant leading-loose">We started as a small boutique in Dar es Salaam with a mission to curate only the finest dermatologically tested products. Today, we are Tanzania's premier destination for high-end beauty, representing over 40 international luxury brands while fostering local organic innovation.</p>
                </div>
                <div class="aspect-square bg-surface-container rounded-full overflow-hidden shadow-2xl">
                     <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-surface-container-low p-20 rounded-[4rem] text-center space-y-8">
                <h3 class="text-3xl font-black text-on-surface uppercase tracking-tighter">International Standards. Local Heart.</h3>
                <p class="text-on-surface-variant max-w-2xl mx-auto">From our temperature-controlled logistic hubs to our expert beauty consultants, every touchpoint of Niffer Cosmetic is designed to meet the rigorous standards of international luxury retail.</p>
                <div class="flex flex-wrap justify-center gap-12 pt-12 opacity-50">
                    <div class="flex flex-col items-center">
                        <span class="material-symbols-outlined text-4xl mb-2">verified</span>
                        <span class="text-[10px] font-black tracking-widest uppercase">100% Authentic</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="material-symbols-outlined text-4xl mb-2">eco</span>
                        <span class="text-[10px] font-black tracking-widest uppercase">Cruelty Free</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="material-symbols-outlined text-4xl mb-2">public</span>
                        <span class="text-[10px] font-black tracking-widest uppercase">Global Brands</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
