@extends('layouts.master')

@section('content')
<section class="py-24 bg-surface-container-low min-h-screen relative overflow-hidden">
    <!-- Luxury Background Accents -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-secondary/5 rounded-full blur-[120px] translate-y-1/2 -translate-x-1/2"></div>

    <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto relative z-10">
        <div class="text-center mb-16">
            <h1 class="font-headline-sm text-5xl text-on-surface mb-4">Our Luxury Destinations</h1>
            <p class="text-on-surface-variant max-w-2xl mx-auto text-lg italic font-serif">Experience Angels Beauty across Tanzania. Each location offers a curated selection of premium skincare and fragrances.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($branches as $branch)
                <div class="group relative bg-white/40 backdrop-blur-xl border border-white/20 rounded-[2.5rem] overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-700 hover:-translate-y-2">
                    <!-- Branch Image Overlay (Glassmorphism) -->
                    <div class="aspect-[4/5] bg-surface-container-high relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10"></div>
                        <img src="https://images.unsplash.com/photo-1541604193435-220b2f3bd963?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000" alt="{{ $branch->name }}">
                        
                        <div class="absolute bottom-8 left-8 right-8 z-20">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md border border-white/30 text-[10px] uppercase font-bold text-white tracking-[0.2em] rounded-full mb-3 inline-block">Official Store</span>
                            <h3 class="text-3xl font-headline-sm text-white">{{ $branch->name }}</h3>
                            <p class="text-white/80 text-sm mt-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-primary-container">location_on</span>
                                {{ $branch->location }}
                            </p>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary">pin_drop</span>
                                <p class="text-sm text-on-surface-variant">{{ $branch->address }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">phone</span>
                                <p class="text-sm text-on-surface-variant">{{ $branch->phone }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">schedule</span>
                                <p class="text-sm text-on-surface-variant">Mon - Sun: 09:00 AM - 09:00 PM</p>
                            </div>
                        </div>

                        <a href="{{ route('branches.switch', $branch->slug) }}" class="block w-full py-4 bg-on-background text-white text-center rounded-xl font-bold uppercase tracking-widest text-[11px] hover:bg-primary transition-all shadow-lg shadow-black/10">
                            Shop This Branch
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
