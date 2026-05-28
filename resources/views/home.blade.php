@extends('layouts.master')

@section('content')
<!-- Hero Section -->
<section class="relative h-[819px] w-full flex items-center overflow-hidden">
<div class="absolute inset-0 z-0">
<img class="w-full h-full object-cover" data-alt="Angels Beauty Luxury Banner" src="{{ asset('niffer/8.jpeg') }}"/>
<div class="absolute inset-0 bg-gradient-to-r from-background/60 via-background/20 to-transparent"></div>
</div>
<div class="relative z-10 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full">
<div class="max-w-2xl">
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-stack-md leading-tight">
                        The Art of <br/><span class="text-primary italic">Angels Beauty</span>
</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-stack-lg max-w-md">
                        Discover a curated collection of global luxury and local radiance, tailored for the sophisticated Tanzanian spirit.
                    </p>
<div class="flex flex-wrap gap-4">
<a href="{{ route('products.index') }}" class="bg-on-background text-on-secondary px-8 py-4 rounded-none font-label-md uppercase tracking-widest hover:bg-primary transition-all duration-500 inline-block text-center">Shop Collection</a>
<a href="{{ route('home') }}" class="border border-on-background text-on-background px-8 py-4 rounded-none font-label-md uppercase tracking-widest hover:bg-on-background hover:text-white transition-all duration-500 inline-block text-center">Our Story</a>
</div>
</div>
</div>
</section>
<!-- Fast Delivery Banner -->
<section class="bg-primary-container/20 py-4 overflow-hidden whitespace-nowrap">
<div class="flex items-center animate-pulse gap-12 px-margin-mobile">
<span class="flex items-center gap-2 font-label-md text-on-primary-container">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">bolt</span>
                    FAST DELIVERY IN DAR ES SALAAM
                </span>
<span class="flex items-center gap-2 font-label-md text-on-primary-container">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">bolt</span>
                    SAME DAY SHIPPING AVAILABLE
                </span>
<span class="flex items-center gap-2 font-label-md text-on-primary-container">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">bolt</span>
                    FAST DELIVERY IN DAR ES SALAAM
                </span>
<span class="flex items-center gap-2 font-label-md text-on-primary-container">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">bolt</span>
                    SAME DAY SHIPPING AVAILABLE
                </span>
</div>
</section>
<!-- Trending Now Product Carousel -->
<section class="py-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="flex justify-between items-end mb-stack-lg">
<div>
<h2 class="font-headline-md text-headline-md text-on-surface">Trending Now</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Most loved by our community this month.</p>
</div>
<div class="flex gap-2">
<button class="p-2 border border-outline-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">chevron_left</span></button>
<button class="p-2 border border-outline-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">chevron_right</span></button>
</div>
</div>
<div class="flex gap-gutter overflow-x-auto no-scrollbar pb-stack-md">
@foreach($trendingProducts as $product)
<!-- Product Card -->
<div class="min-w-[280px] md:min-w-[320px] group relative">
<div class="relative overflow-hidden aspect-[4/5] mb-stack-sm bg-surface-container-low group/img">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="{{ $product->name }}" src="{{ $product->image_url }}"/>
<form action="{{ route('cart.add', $product->id) }}" method="POST" class="absolute bottom-0 left-0 right-0 glass p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 flex justify-between items-center cursor-pointer">
@csrf
<button type="submit" class="flex justify-between items-center w-full">
<span class="font-label-md text-on-surface">Quick Add</span>
<span class="material-symbols-outlined text-primary">add</span>
</button>
</form>
</div>
<p class="font-label-sm text-secondary uppercase tracking-widest">{{ $product->brand }}</p>
<h3 class="font-body-lg text-body-lg text-on-surface group-hover:text-primary transition-colors">{{ $product->name }}</h3>
<p class="font-label-md text-primary font-bold mt-1">{{ number_format($product->price) }} TZS</p>
</div>
@endforeach
</div>

<!-- Extra Professional Section: Testimonials -->
<section id="testimonial-section" class="py-stack-lg bg-surface-container-highest/20 overflow-hidden">
    <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto text-center">
        <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-lg">Voices of Radiance</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="p-8 bg-white border border-outline-variant/30 relative">
                <span class="material-symbols-outlined text-primary-fixed text-4xl absolute -top-5 left-1/2 -translate-x-1/2 bg-white px-2">format_quote</span>
                <p class="italic text-on-surface-variant font-body-md mb-6 pt-4">"Angels  Beauty has transformed my daily skincare routine. The authenticity of the products is unmatched in Dar."</p>
                <div class="mt-4">
                    <p class="font-bold text-on-surface uppercase text-xs tracking-widest">Amina Juma</p>
                    <p class="text-[10px] text-primary">Gold Member</p>
                </div>
            </div>
            <div class="p-8 bg-white border border-outline-variant/30 relative">
                <span class="material-symbols-outlined text-primary-fixed text-4xl absolute -top-5 left-1/2 -translate-x-1/2 bg-white px-2">format_quote</span>
                <p class="italic text-on-surface-variant font-body-md mb-6 pt-4">"Same-day delivery is a game changer for my busy office schedule. Professional service every single time."</p>
                <div class="mt-4">
                    <p class="font-bold text-on-surface uppercase text-xs tracking-widest">Sarah Mussa</p>
                    <p class="text-[10px] text-primary">VIP Customer</p>
                </div>
            </div>
            <div class="p-8 bg-white border border-outline-variant/30 relative">
                <span class="material-symbols-outlined text-primary-fixed text-4xl absolute -top-5 left-1/2 -translate-x-1/2 bg-white px-2">format_quote</span>
                <p class="italic text-on-surface-variant font-body-md mb-6 pt-4">"The mobile money integration makes it so easy for me to buy my favorite luxury perfumes instantly."</p>
                <div class="mt-4">
                    <p class="font-bold text-on-surface uppercase text-xs tracking-widest">Grace Peter</p>
                    <p class="text-[10px] text-primary">Beauty Expert</p>
                </div>
            </div>
        </div>
    </div>
</section>
</section>
<!-- Beauty Collections (Asymmetric Layout) -->
<section class="py-stack-lg bg-surface-container-low">
<div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<h2 class="font-headline-md text-headline-md text-on-surface mb-stack-lg text-center">Curated Collections</h2>
<div class="grid grid-cols-1 md:grid-cols-12 gap-gutter h-auto md:h-[700px]">
<!-- Skincare (Large) -->
<div class="md:col-span-8 relative overflow-hidden group">
<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" data-alt="Skincare Collection" src="{{ asset('niffer/7.jpeg') }}"/>
<div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-500"></div>
<div class="absolute bottom-10 left-10">
<h3 class="font-display-lg text-display-lg text-white mb-2">Skincare</h3>
<p class="text-white/80 mb-6 max-w-xs font-body-md">The foundation of every morning ritual. Science-backed formulas for every skin type.</p>
<a class="inline-block bg-white text-on-background px-8 py-3 font-label-md uppercase tracking-wider hover:bg-primary hover:text-white transition-all" href="#">Explore All</a>
</div>
</div>
<!-- Right Column Grid -->
<div class="md:col-span-4 flex flex-col gap-gutter">
<!-- Fragrance -->
<div class="relative h-1/2 overflow-hidden group">
<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" data-alt="Fragrance Collection" src="{{ asset('niffer/6.jpeg') }}"/>
<div class="absolute inset-0 bg-black/10 group-hover:bg-black/30 transition-colors duration-500"></div>
<div class="absolute bottom-6 left-6">
<h3 class="font-headline-sm text-headline-sm text-white">Fragrance</h3>
<a class="text-white text-label-sm uppercase tracking-widest border-b border-white/50 hover:border-white transition-all" href="#">Shop Scent</a>
</div>
</div>

<!-- hair-->


<!-- Makeup -->
<div class="relative h-1/2 overflow-hidden group">
<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" data-alt="Macro photography of vibrant makeup powders and palettes arranged in an artistic, messy-yet-chic layout. The textures of the powders are detailed and tactile. The color palette includes soft rose, terracotta, and champagne gold. The setting is a professional beauty studio with soft, even lighting that emphasizes the pigments and textures. Minimalist and modern aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCxi3yqa1waRo5bRDWL8tjuuaYsE8Qq5bP10NLIQ66gd_Rps6M47XQcPOjDWw8dGH1AAkn6GPC-tF4-o42ZNkMmL2llgvExCW9eejXymV5adMtUMcCDdCWfGUjQM0Ed4mVQP9oTLW9BHxWppWiCbRea6NAOLgMFL7br1ynRr-fYdBD0t5Rq7_RG4kch03UOKUCpg1DE-5vKMZBEI6zX3p0qbJ4yk0BG_6kD6N25jzuFnTRoMS0rNVw6wVI-JbukJ5D4ml3He00wpzY"/>
<div class="absolute inset-0 bg-black/10 group-hover:bg-black/30 transition-colors duration-500"></div>
<div class="absolute bottom-6 left-6">
<h3 class="font-headline-sm text-headline-sm text-white">Makeup</h3>
<a class="text-white text-label-sm uppercase tracking-widest border-b border-white/50 hover:border-white transition-all" href="#">View Palette</a>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Featured Brands -->
<section class="py-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<h2 class="font-label-sm text-secondary text-center uppercase tracking-[0.3em] mb-stack-lg">Global &amp; Local Excellence</h2>
<div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 grayscale opacity-60 hover:opacity-100 transition-opacity">
<span class="font-headline-sm tracking-tighter text-on-surface">L'ORÉAL</span>
<span class="font-headline-sm tracking-tighter text-on-surface">FENTY BEAUTY</span>
<span class="font-headline-sm tracking-tighter text-on-surface">CHANEL</span>
<span class="font-headline-sm tracking-tighter text-on-surface">SWAHILI CARE</span>
<span class="font-headline-sm tracking-tighter text-on-surface">LA MER</span>
</div>
</section>
<!-- Payment & Delivery Methods -->
<section class="py-stack-lg border-t border-outline-variant/30">
<!-- Beauty Expert Advice Section -->
<section class="py-stack-lg bg-on-background text-white overflow-hidden">
    <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
            <div class="relative">
                <div class="border border-white/20 p-2 inline-block mb-stack-md overflow-hidden group cursor-pointer">
                    <img class="w-full h-[500px] object-cover transition-transform duration-1000 group-hover:scale-110" src="{{ asset('niffer/13.jpeg') }}" alt="Beauty Expert">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-primary p-8 hidden md:block">
                    <p class="font-headline-sm text-headline-sm italic">"Your skin is an investment, not an expense."</p>
                </div>
            </div>
            <div>
                <h2 class="font-display-lg text-display-lg mb-stack-md">Personalized <span class="text-primary-fixed">Radiance</span></h2>
                <p class="font-body-lg text-white/70 mb-8">Connect with our Tanzanian beauty consultants for a routine tailored to your unique environment and skin needs. From coastal humidity to highland air, we know what works for you.</p>
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-primary-fixed">verified</span>
                        <span class="font-label-md uppercase tracking-widest">Certified Dermatologists</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-primary-fixed">verified</span>
                        <span class="font-label-md uppercase tracking-widest">Custom Skin Analysis</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-primary-fixed">verified</span>
                        <span class="font-label-md uppercase tracking-widest">24/7 Expert Support</span>
                    </div>
                </div>
                <a href="{{ route('consultation.create') }}" class="mt-12 inline-block border border-white text-white px-12 py-4 font-label-md uppercase tracking-widest hover:bg-white hover:text-on-background transition-all">Book Consultation</a>
            </div>
        </div>
    </div>
</section>

<div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-3 gap-gutter">
<div class="flex flex-col items-center text-center p-8 glass-dark text-white rounded-none">
<span class="material-symbols-outlined text-[48px] mb-4 text-primary-fixed">local_shipping</span>
<h4 class="font-headline-sm text-headline-sm mb-2">Dar Delivery</h4>
<p class="font-body-md text-white/70">Same-day delivery for all orders placed before 2PM within Dar es Salaam.</p>
</div>
<div class="flex flex-col items-center text-center p-8 glass-dark text-white rounded-none">
<span class="material-symbols-outlined text-[48px] mb-4 text-primary-fixed">payments</span>
<h4 class="font-headline-sm text-headline-sm mb-2">Mobile Money</h4>
<p class="font-body-md text-white/70">Securely pay via M-Pesa, Tigo Pesa, or Airtel Money at checkout.</p>
</div>
<div class="flex flex-col items-center text-center p-8 glass-dark text-white rounded-none">
<span class="material-symbols-outlined text-[48px] mb-4 text-primary-fixed">verified</span>
<h4 class="font-headline-sm text-headline-sm mb-2">100% Authentic</h4>
<p class="font-body-md text-white/70">We guarantee only genuine products directly from authorized distributors.</p>
</div>
</div>
</section>
@endsection