@extends('layouts.master')

@section('content')
<!-- Hero Section for Branch -->
<section class="h-[60vh] relative overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc4033c8?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover filter brightness-[0.7]" alt="{{ $branch->name }}">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-surface-container-low"></div>
    </div>
    
    <div class="relative z-10 text-center px-margin-mobile">
        <span class="text-white font-bold uppercase tracking-[0.4em] text-xs mb-4 block animate-in fade-in slide-in-from-bottom-4 duration-1000">Luxury Cosmetic Destination</span>
        <h1 class="font-headline-sm text-6xl md:text-8xl text-white mb-6 drop-shadow-xl animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-200">{{ $branch->name }}</h1>
        <div class="flex flex-wrap justify-center gap-6 animate-in fade-in slide-in-from-bottom-12 duration-1000 delay-500">
            <div class="flex items-center gap-2 text-white/90">
                <span class="material-symbols-outlined text-primary-container">near_me</span>
                <span class="font-medium underline underline-offset-8 decoration-primary-container/50 tracking-wide">{{ $branch->location }}</span>
            </div>
            <div class="flex items-center gap-2 text-white/90">
                <span class="material-symbols-outlined text-primary-container">call</span>
                <span class="font-medium tracking-wide">{{ $branch->phone }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Branch Details Card (Glassmorphism) -->
<section class="relative -mt-24 pb-24 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto z-20">
    <div class="bg-white/70 backdrop-blur-3xl border border-white/40 p-12 rounded-[3.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] flex flex-col md:flex-row gap-12 items-center">
        <div class="flex-1 space-y-6">
            <h2 class="font-headline-sm text-4xl text-on-surface">About This Location</h2>
            <p class="text-on-surface-variant leading-relaxed text-lg">Welcome to the {{ $branch->name }}. Our branch offers Tanzania's most exquisite beauty experience. Visit us to consult with our beauty experts, try on the latest fragrances, and discover our premium collection.</p>
            
            <div class="grid grid-cols-2 gap-8 pt-6">
                <div>
                    <p class="text-[10px] uppercase font-bold text-primary tracking-widest mb-2">Available Services</p>
                    <ul class="text-sm space-y-2 text-on-surface">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span> Skin Consultation</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span> Fragrance Bar</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span> Gift Wrapping</li>
                    </ul>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold text-primary tracking-widest mb-2">Shopping Options</p>
                    <ul class="text-sm space-y-2 text-on-surface">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span> In-Store Pickup</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span> Immediate Delivery</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-primary rounded-full"></span> Reserve Online</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="w-full md:w-[400px] aspect-square rounded-[2.5rem] overflow-hidden shadow-2xl bg-surface-container border-8 border-white/50">
            @if($branch->map_url)
                <iframe src="{{ $branch->map_url }}" class="w-full h-full border-0 grayscale invert-[5%]" allowfullscreen="" loading="lazy"></iframe>
            @else
                <div class="w-full h-full flex flex-col items-center justify-center bg-primary-container/10">
                    <span class="material-symbols-outlined text-6xl text-primary mb-4">map</span>
                    <p class="text-primary font-bold uppercase tracking-widest text-xs">Map View Available Soon</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Trending in this branch -->
<section class="py-24 bg-white overflow-hidden">
    <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h3 class="font-headline-sm text-4xl mb-2">Trending in {{ $branch->slug }}</h3>
                <p class="text-on-surface-variant italic">The most loved products at this location.</p>
            </div>
            <a href="{{ route('products.index') }}" class="px-8 py-3 bg-on-background text-white rounded-full font-bold uppercase tracking-widest text-xs hover:bg-primary transition-all">Explore All</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Product Cards here... -->
            @foreach(\App\Models\Product::whereHas('branches', function($q) use ($branch) { $q->where('branch_id', $branch->id); })->take(4)->get() as $product)
                <div class="group">
                    <div class="aspect-[3/4] bg-surface-container rounded-[2rem] overflow-hidden relative mb-4">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $product->name }}">
                        <div class="absolute bottom-4 left-4 right-4 translate-y-20 group-hover:translate-y-0 transition-transform duration-500">
                             <a href="{{ route('products.show', $product->id) }}" class="block w-full py-3 bg-white/90 backdrop-blur-md text-on-surface text-center rounded-xl font-bold uppercase tracking-widest text-[10px]">View Details</a>
                        </div>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-secondary font-bold mb-1">{{ $product->brand }}</p>
                    <h4 class="font-bold text-lg text-on-surface">{{ $product->name }}</h4>
                    <p class="text-primary font-bold mt-2">{{ number_format($product->price) }} TZS</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
