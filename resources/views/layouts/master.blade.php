<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#1a1c1c",
                        "surface-tint": "#735c00",
                        "inverse-on-surface": "#f0f1f1",
                        "on-tertiary-fixed-variant": "#5e3f3e",
                        "on-secondary": "#ffffff",
                        "secondary-fixed-dim": "#c8c6c5",
                        "on-error": "#ffffff",
                        "on-tertiary-container": "#5c3d3d",
                        "on-tertiary": "#ffffff",
                        "primary-container": "#d4af37",
                        "secondary-container": "#e2dfde",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed": "#2d1415",
                        "on-primary-fixed": "#241a00",
                        "inverse-surface": "#2f3131",
                        "on-primary-container": "#554300",
                        "on-primary-fixed-variant": "#574500",
                        "secondary": "#5f5e5e",
                        "primary": "#735c00",
                        "surface-variant": "#e2e2e2",
                        "primary-fixed": "#ffe088",
                        "primary-fixed-dim": "#e9c349",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed": "#e5e2e1",
                        "on-secondary-container": "#636262",
                        "surface-container-low": "#f3f3f4",
                        "on-primary": "#ffffff",
                        "outline-variant": "#d0c5af",
                        "surface-container-highest": "#e2e2e2",
                        "inverse-primary": "#e9c349",
                        "surface-container-high": "#e8e8e8",
                        "on-surface": "#1a1c1c",
                        "on-surface-variant": "#4d4635",
                        "tertiary-fixed": "#ffdad9",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "outline": "#7f7663",
                        "tertiary-container": "#d3a9a8",
                        "on-secondary-fixed": "#1c1b1b",
                        "tertiary-fixed-dim": "#e8bcbb",
                        "surface-container": "#eeeeee",
                        "background": "#f9f9f9",
                        "surface": "#f9f9f9",
                        "surface-dim": "#dadada",
                        "tertiary": "#785655",
                        "surface-bright": "#f9f9f9",
                        "on-secondary-fixed-variant": "#474746"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "margin-desktop": "40px",
                        "stack-lg": "32px",
                        "stack-md": "16px",
                        "margin-mobile": "16px",
                        "container-max": "1280px",
                        "gutter": "24px",
                        "stack-sm": "8px"
                    },
                    "fontFamily": {
                        "headline-sm": ["Playfair Display"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-md": ["Playfair Display"],
                        "display-lg": ["Playfair Display"],
                        "label-md": ["Inter"],
                        "display-lg-mobile": ["Playfair Display"],
                        "label-sm": ["Inter"]
                    },
                    "fontSize": {
                        "headline-sm": ["24px", {"lineHeight": "1.4", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "headline-md": ["32px", {"lineHeight": "1.3", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-md": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "display-lg-mobile": ["36px", {"lineHeight": "1.2", "fontWeight": "700"}],
                        "label-sm": ["12px", {"lineHeight": "1.2", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- jQuery for Cart AJAX -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-background text-on-background font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container">
<!-- Top Navigation Bar -->
<!-- Top Navigation Bar -->
<nav class="bg-white/90 dark:bg-on-background/90 backdrop-blur-xl text-on-surface docked full-width top-0 sticky z-50 border-b border-outline-variant/10 shadow-sm transition-all duration-500">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-3 md:py-4">
        <div class="flex justify-between items-center gap-8">
            <!-- Brand Logo -->
            <a class="flex flex-col group" href="{{ route('home') }}">
                <span class="font-headline-md text-3xl md:text-4xl tracking-tighter text-on-surface group-hover:text-primary transition-all duration-500 transform group-active:scale-95 leading-none">Niffer</span>
                <span class="text-[10px] uppercase font-black tracking-[0.4em] text-primary mt-1 opacity-80 group-hover:opacity-100 transition-opacity">Cosmetic</span>
            </a>

            <!-- Main Navigation (Config-Driven Mega Menu) -->
            <div class="hidden xl:flex items-center gap-2">
                @foreach($megaMenuData as $key => $category)
                    <div class="relative group py-4">
                        <a href="{{ route('category.show', $key) }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl font-label-md text-on-surface-variant group-hover:text-primary group-hover:bg-primary-container/10 transition-all duration-300">
                            {{ $category['label'] }}
                            <span class="material-symbols-outlined text-[16px] group-hover:rotate-180 transition-transform duration-300">expand_more</span>
                        </a>

                        <!-- Mega Dropdown Panel -->
                        <div class="absolute top-full left-0 mt-0 w-[600px] bg-white border border-outline-variant/30 shadow-2xl rounded-b-[2rem] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 overflow-hidden transform translate-y-4 group-hover:translate-y-0">
                            <div class="flex">
                                <!-- Left Info Section -->
                                <div class="w-1/3 bg-surface-container-low p-8 border-r border-outline-variant/30">
                                    <h3 class="font-headline-sm text-2xl text-on-surface mb-2">{{ $category['label'] }}</h3>
                                    <p class="text-xs text-on-surface-variant leading-relaxed mb-6 opacity-70">{{ $category['description'] }}</p>
                                    <a href="{{ route('category.show', $key) }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-primary hover:gap-4 transition-all">
                                        Explore All <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </a>
                                </div>
                                <!-- Right Subcategories Section -->
                                <div class="w-2/3 p-8 grid grid-cols-2 gap-y-4 gap-x-8">
                                    @foreach($category['subcategories'] as $sub)
                                        <a href="/category/{{ $key }}/{{ $sub['slug'] }}" class="flex items-center gap-2 group/item">
                                            <div class="w-1.5 h-1.5 rounded-full bg-outline-variant group-hover/item:bg-primary transition-colors"></div>
                                            <span class="text-sm text-on-surface-variant group-hover/item:text-primary group-hover/item:font-bold transition-all">{{ $sub['name'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Bottom Banner (Optional) -->
                            <div class="bg-primary/5 px-8 py-3 flex justify-between items-center">
                                <span class="text-[9px] uppercase font-black tracking-tighter text-primary opacity-60">Free shipping on all {{ $category['label'] }} orders over 50,000 TZS</span>
                                <span class="material-symbols-outlined text-sm text-primary">verified</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <a href="{{ route('customer.loyalty') }}" class="ml-4 flex items-center gap-2 px-5 py-2 bg-pink-50/50 text-pink-600 rounded-full font-black text-[11px] uppercase tracking-widest hover:bg-pink-600 hover:text-white transition-all duration-500 shadow-sm shadow-pink-100 group">
                    <span class="material-symbols-outlined text-[18px] group-hover:rotate-12 transition-transform">workspace_premium</span>
                    Rewards
                </a>
            </div>

            <!-- Actions Wrapper -->
            <div class="flex items-center gap-6 flex-1 justify-end max-w-2xl">
                <!-- Branch Switcher -->
                <div class="relative group hidden sm:block">
                    <button class="flex items-center gap-3 px-5 py-2.5 bg-surface-container-low border border-outline-variant/20 rounded-2xl hover:bg-white hover:shadow-xl hover:shadow-primary-container/10 transition-all duration-500 group">
                        <div class="w-8 h-8 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[18px]">location_on</span>
                        </div>
                        <div class="flex flex-col items-start min-w-[100px]">
                            <span class="text-[8px] uppercase font-black text-on-surface-variant tracking-tighter leading-none mb-1 opacity-60">Your Branch</span>
                            <span class="text-[11px] font-bold text-on-surface truncate max-w-[120px]">{{ session('active_branch_name', 'Select Branch') }}</span>
                        </div>
                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant group-hover:rotate-180 transition-transform">expand_more</span>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full right-0 mt-4 w-72 bg-white border border-outline-variant shadow-2xl rounded-[1.5rem] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 overflow-hidden transform translate-y-2 group-hover:translate-y-0">
                        <div class="p-6 bg-surface-container-low border-b border-outline-variant/30">
                            <h4 class="text-[10px] uppercase font-black text-primary tracking-[0.2em]">Select Destination</h4>
                        </div>
                        <div class="max-h-[300px] overflow-y-auto">
                            @foreach($all_branches as $branch)
                                <a href="{{ route('branches.switch', $branch->slug) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-primary-container/10 transition-all {{ session('active_branch_id') == $branch->id ? 'bg-primary-container/5 border-l-4 border-primary' : '' }}">
                                    <div class="flex-1">
                                        <p class="font-bold text-on-surface text-sm">{{ $branch->name }}</p>
                                        <p class="text-[10px] text-on-surface-variant">{{ $branch->location }}</p>
                                    </div>
                                    @if(session('active_branch_id') == $branch->id)
                                        <span class="material-symbols-outlined text-primary text-sm">verified</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Interactive Search Dropdown -->
                <div class="relative group">
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-primary-container/10 text-on-surface-variant hover:text-primary transition-all duration-300">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <!-- Search Panel -->
                    <div class="absolute top-full right-0 mt-4 w-[350px] bg-white border border-outline-variant/30 shadow-2xl rounded-[2rem] opacity-0 invisible group-hover:opacity-100 group-hover:visible focus-within:opacity-100 focus-within:visible transition-all duration-500 z-50 p-6 transform translate-y-4 group-hover:translate-y-0 focus-within:translate-y-0 mx-4 md:mx-0">
                        <div class="mb-4 flex items-center justify-between">
                            <h4 class="text-[10px] uppercase font-black text-primary tracking-[0.2em]">Find your Radiance</h4>
                            <span class="material-symbols-outlined text-outline text-sm">auto_awesome</span>
                        </div>
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="relative items-center flex">
                                <span class="material-symbols-outlined absolute left-4 text-primary">search</span>
                                <input name="q" value="{{ request('q') }}" class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary/20 rounded-2xl py-4 pl-12 pr-4 text-label-md font-medium" placeholder="Search brands, scents, or skin goals..." autofocus/>
                            </div>
                        </form>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <p class="text-[9px] text-on-surface-variant font-bold uppercase w-full mb-1 opacity-60">Trending Searches:</p>
                            <a href="/search?q=fragrance" class="text-[10px] bg-surface-container px-3 py-1.5 rounded-full hover:bg-primary/10 hover:text-primary transition-colors">Dior Scent</a>
                            <a href="/search?q=serum" class="text-[10px] bg-surface-container px-3 py-1.5 rounded-full hover:bg-primary/10 hover:text-primary transition-colors">Vitamin C</a>
                            <a href="/search?q=sunscreen" class="text-[10px] bg-surface-container px-3 py-1.5 rounded-full hover:bg-primary/10 hover:text-primary transition-colors">SPF 50+</a>
                        </div>
                    </div>
                </div>

                <!-- Icon Buttons -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('customer.wishlist') }}" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-pink-50 text-on-surface-variant hover:text-pink-600 transition-all duration-300">
                        <span class="material-symbols-outlined">favorite</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-primary-container/10 text-on-surface-variant hover:text-primary transition-all duration-300">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1 -right-1 bg-primary text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-on-background text-white hover:bg-primary hover:shadow-xl transition-all duration-500">
                        <span class="material-symbols-outlined">person</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<main class="relative">
    <!-- Quick Access Navigation (Hidden on Home) -->
    @if(!request()->routeIs('home') && !request()->is('admin*'))
    <div class="sticky top-20 z-40 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto pointer-events-none">
        <div class="flex gap-2 pt-4 pointer-events-auto">
            <button onclick="window.history.back()" class="flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-outline-variant/30 rounded-xl shadow-sm hover:bg-primary hover:text-white transition-all group">
                <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                <span class="text-[10px] font-black uppercase tracking-widest">Back</span>
            </button>
            <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-outline-variant/30 rounded-xl shadow-sm hover:bg-on-background hover:text-white transition-all group">
                <span class="material-symbols-outlined text-sm">home</span>
                <span class="text-[10px] font-black uppercase tracking-widest">Home</span>
            </a>
        </div>
    </div>
    @endif

@yield('content')
</main>
<!-- Footer -->
<footer class="bg-surface dark:bg-on-background border-t border-outline-variant pt-stack-lg pb-10">
<div class="grid grid-cols-2 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto mb-12">
<div>
<h3 class="font-headline-sm text-headline-sm text-on-surface dark:text-inverse-on-surface mb-6">Niffer Cosmetic</h3>
<p class="text-secondary font-body-md mb-6">Tanzania's premier destination for high-end beauty and skincare excellence.</p>
<div class="flex gap-4">
<a class="text-secondary hover:text-pink-600 transition-all text-xl" href="https://www.instagram.com/niffer_cosmetics_/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
<a class="text-secondary hover:text-[#1877F2] transition-all text-xl" href="https://www.facebook.com/niffercosmetic/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
<a class="text-secondary hover:text-black transition-all text-xl" href="https://x.com/niffercosmetic" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
</div>
</div>
<div>
<h4 class="font-label-md text-label-md text-primary uppercase mb-6">Explore</h4>
<ul class="space-y-4">
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.brand-story') }}">Brand Story</a></li>
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="https://www.instagram.com/niffer_cosmetics_/" target="_blank">Instagram</a></li>
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.store-locator') }}">Store Locator</a></li>
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.contact') }}">Contact Us</a></li>
</ul>
</div>
<div>
<h4 class="font-label-md text-label-md text-primary uppercase mb-6">Help &amp; Support</h4>
<ul class="space-y-4">
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.track-order') }}">Track Your Order</a></li>
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.mpesa-guide') }}">M-Pesa Guide</a></li>
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.mpesa-guide') }}">Mobile Money Help</a></li>
</ul>
</div>
<div>
<h4 class="font-label-md text-label-md text-primary uppercase mb-6">Legal</h4>
<ul class="space-y-4">
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.shipping-policy') }}">Shipping Policy</a></li>
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.return-policy') }}">Return Policy</a></li>
<li><a class="text-secondary hover:text-primary hover:underline transition-all font-body-md text-body-md" href="{{ route('pages.privacy-policy') }}">Privacy Policy</a></li>
</ul>
</div>
</div>
<div class="border-t border-outline-variant/30 pt-8 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
<p class="font-label-md text-label-md text-secondary">© 2023 Niffer Cosmetic Tanzania. All Rights Reserved.</p>
<div class="flex gap-6 items-center opacity-60">
<img alt="M-Pesa" class="h-6" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBnNRX9Fh8b2lcSv28dGmoCitvHXAjErZ_Dq9sljeaAjVjDpDHXBNimO5CzIKPFoXHVFzCBYG9r0RR77SeWzjNOeP1RT6Tfk6mC3XbHENm1RlF9xTzt6Oymp4zq62iJTt3VRfndjIPlKyvMJTIOS5Fz_1kMVD5EnU3RkrRZR5BPnuGOskHlxjvt7-LEus3wH1g0ZNvxtQB9IUsp9dKf-NvngO9CNjvG7_wnH6QBbVLf0uejcKPJ_1smoBGMnxL6gmK-LCjDtUK3ZHc"/>
<img alt="Airtel" class="h-6" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3dL59m_Fe8j8Lq3YghhGM5IPh6yTzNzMtpO6kWxf-G0faOE1wUJ10P_u8rcZdjd-cpJQqV7VcrRS0UnMQHnbJpVcFO8WkOdlDOAuZq2K6_PVo4EiPHCWaQHg041yqk0chRSbBurrcTNFSf6-9X_qWIXYCdXWOYyxqkRLvjm2ECQZKXayOsoin7hL3GF0xexQx2pVLr04RQdaN8VZESIrHYZP0BQd9P7aBLw8WLq923EK-_i1FQmkObOGgjq3DKkjYqlyYUeoQkJg"/>
<img alt="Tigo" class="h-6" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAuuW3zRShaqKK4ztS62gjEDV7hDO5Kijsq-4dPoLlzvsuk7ipCcfKOXaHOtWd3yRRqitTu4j3GVorQ7GqsYSD9VT2EI6SqjyiXonKYtMnacirgQZmIfRl8tWzlgH9mKL7LlqFOpcqVVKs7aqD2BYoJ0CfcQ7KLZEqP8GAm2AcXhcIzo07TurDf6vAWjBN6Y83XfQ99vlX8txlueJR_LztnntNENFbzJSrbrUQGMwaprPBJbntaCSBio2oJWKVPWvfqdVJX5lKyoEU"/>
</div>
</div>
</footer>
    @stack('scripts')
    @include('components.beauty-ai-chat')
</body></html>