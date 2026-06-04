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
<!-- Top Navigation Bar (Sephora Style) -->
<nav class="bg-white dark:bg-on-background text-on-surface border-b border-outline-variant/10 shadow-sm transition-all duration-500">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-4 lg:py-6">
        <div class="flex items-center justify-between gap-6 lg:gap-10">
            <!-- Brand Logo -->
            <a class="flex flex-col group flex-shrink-0" href="{{ route('home') }}">
                <span class="font-headline-md text-3xl lg:text-4xl tracking-[0.2em] uppercase font-black text-on-surface transition-all duration-500 leading-none">Niffer</span>
            </a>

            <!-- Search Bar (Pill Shape) -->
            <div class="hidden md:flex flex-grow max-w-2xl relative group">
                <form action="{{ route('products.index') }}" method="GET" class="w-full">
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-5 text-on-surface-variant/60 group-focus-within:text-primary transition-colors">search</span>
                        <input name="q" value="{{ request('q') }}" class="w-full bg-surface-container-low/50 border border-on-surface-variant/20 hover:border-on-surface-variant/40 focus:border-primary focus:ring-4 focus:ring-primary/5 rounded-full py-2.5 lg:py-3.5 pl-14 pr-6 text-sm font-medium transition-all" placeholder="Search brands, products, skin goals..."/>
                    </div>
                </form>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-1 lg:gap-6 flex-shrink-0">
                <!-- AI Beauty Chat -->
                <button onclick="toggleBeautyAI()" class="hidden xl:flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-surface-container-low transition-all group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-pink-500/10 to-purple-500/10 flex items-center justify-center relative">
                        <span class="material-symbols-outlined text-pink-600 group-hover:rotate-12 transition-transform">auto_awesome</span>
                        <span class="absolute -top-1 -right-1 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-pink-500"></span>
                        </span>
                    </div>
                    <div class="flex flex-col items-start leading-tight">
                        <span class="text-[11px] font-bold">AI Beauty Chat</span>
                        <span class="text-[9px] bg-black text-white px-1.5 py-0.5 rounded font-black uppercase tracking-tighter">New</span>
                    </div>
                </button>

                <!-- Store & Delivery -->
                <div class="relative group hidden lg:flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-2xl text-on-surface-variant">store</span>
                    <div class="flex flex-col items-start leading-tight">
                        <span class="text-[11px] font-bold">Shop Store & Delivery</span>
                        <span class="text-[9px] text-on-surface-variant font-medium underline cursor-pointer">{{ session('active_branch_name', 'Choose your store & location') }}</span>
                    </div>
                    <!-- Branch Dropdown -->
                    <div class="absolute top-full right-0 mt-2 w-72 bg-white border border-outline-variant shadow-2xl rounded-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden translate-y-2 group-hover:translate-y-0">
                        <div class="p-4 bg-surface-container-low border-b border-outline-variant/30">
                            <h4 class="text-[9px] uppercase font-black text-primary tracking-[0.15em]">Select Branch</h4>
                        </div>
                        <div class="max-h-[300px] overflow-y-auto">
                            @foreach($all_branches as $branch)
                                <a href="{{ route('branches.switch', $branch->slug) }}" class="flex items-center gap-3 px-4 py-3 hover:bg-primary/5 transition-all {{ session('active_branch_id') == $branch->id ? 'bg-primary/5' : '' }}">
                                    <div class="flex-1">
                                        <p class="font-bold text-on-surface text-[12px]">{{ $branch->name }}</p>
                                        <p class="text-[10px] text-on-surface-variant">{{ $branch->location }}</p>
                                    </div>
                                    @if(session('active_branch_id') == $branch->id)
                                        <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Services & Events -->
                <a href="{{ route('customer.loyalty') }}" class="hidden lg:flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-2xl text-on-surface-variant">calendar_month</span>
                    <div class="flex flex-col items-start leading-tight">
                        <span class="text-[11px] font-bold">Services & Events</span>
                    </div>
                </a>

                <!-- Account / Sign In -->
                <div class="relative group">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-surface-container-low transition-all">
                        <span class="material-symbols-outlined text-[32px] text-on-surface-variant">person</span>
                        <div class="hidden xl:flex flex-col items-start leading-tight">
                            <span class="text-[11px] font-bold">{{ Auth::check() ? Auth::user()->name : 'Sign In' }}</span>
                            @if(!Auth::check())
                                <span class="text-[9px] text-on-surface-variant font-medium">for FREE Shipping 🚚</span>
                            @else
                                <span class="text-[9px] text-primary font-bold">My Account</span>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- Heart Icon -->
                <a href="{{ route('customer.wishlist') }}" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-low text-on-surface-variant transition-all relative">
                    <span class="material-symbols-outlined text-2xl">favorite</span>
                </a>

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-low text-on-surface-variant transition-all relative">
                    <span class="material-symbols-outlined text-2xl">shopping_basket</span>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-1 right-1 bg-black text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center shadow-lg">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Category Navigation Bar -->
<div class="bg-black text-white sticky top-0 z-40 hidden xl:block border-b border-white/5">
    <div class="max-w-container-max mx-auto px-margin-desktop">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                @foreach($megaMenuData as $key => $category)
                    <div class="relative group">
                        <a href="{{ route('category.show', $key) }}" class="flex items-center gap-1 px-5 py-4 text-[11px] font-bold uppercase tracking-widest transition-all duration-300 group-hover:bg-white group-hover:text-black {{ $key === 'sale' ? 'text-red-500' : 'text-white' }}">
                            {{ $category['label'] }}
                            @if(isset($category['subcategories']) || isset($category['sections']))
                                <span class="material-symbols-outlined text-[14px] opacity-50 group-hover:rotate-180 transition-transform duration-300">expand_more</span>
                            @endif
                        </a>

                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 w-max min-w-[280px] bg-white text-on-surface shadow-[0_20px_50px_rgba(0,0,0,0.3)] border-b-2 border-primary opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform translate-y-1 group-hover:translate-y-0">
                            @if(isset($category['is_mega']) && $category['is_mega'])
                                <!-- Complex Mega Menu -->
                                <div class="p-8 flex gap-12">
                                    @foreach($category['sections'] as $title => $links)
                                        <div class="flex flex-col gap-4">
                                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-primary border-b border-primary/10 pb-2">{{ $title }}</h4>
                                            <div class="flex flex-col gap-2">
                                                @foreach($links as $link)
                                                    <a href="/category/{{ $key }}/{{ $link['slug'] }}" class="flex items-center justify-between gap-8 group/link">
                                                        <span class="text-sm text-on-surface-variant group-hover/link:text-primary transition-colors whitespace-nowrap">{{ $link['name'] }}</span>
                                                        @if(isset($link['icon']))
                                                            <span class="material-symbols-outlined text-sm text-primary opacity-0 group-hover/link:opacity-100 transition-all transform -translate-x-2 group-hover/link:translate-x-0">{{ $link['icon'] }}</span>
                                                        @endif
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif(isset($category['subcategories']))
                                <!-- Simple Dropdown -->
                                <div class="p-6">
                                    <div class="mb-4">
                                        <h3 class="font-headline-sm text-xl text-on-surface">{{ $category['label'] }}</h3>
                                        <p class="text-[10px] text-on-surface-variant opacity-70">{{ $category['description'] }}</p>
                                    </div>
                                    <div class="grid grid-cols-1 gap-y-2">
                                        @foreach($category['subcategories'] as $sub)
                                            <a href="/category/{{ $key }}/{{ $sub['slug'] }}" class="flex items-center gap-3 group/item">
                                                <div class="w-1 h-1 rounded-full bg-primary/30 group-hover/item:bg-primary transition-all group-hover/item:scale-150"></div>
                                                <span class="text-sm text-on-surface-variant group-hover/item:text-primary transition-colors">{{ $sub['name'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('category.show', $key) }}" class="mt-6 inline-flex items-center gap-2 text-[9px] font-black uppercase tracking-widest text-primary hover:gap-4 transition-all pt-4 border-t border-outline-variant/20 w-full">
                                        Shop All <span class="material-symbols-outlined text-sm">arrow_right_alt</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('customer.loyalty') }}" class="flex items-center gap-2 px-4 py-2 bg-primary/20 text-white rounded-full font-black text-[9px] uppercase tracking-widest hover:bg-primary transition-all duration-500 group">
                <span class="material-symbols-outlined text-[16px] group-hover:rotate-12 transition-transform">workspace_premium</span>
                Rewards
            </a>
        </div>
    </div>
</div>

<!-- Mobile Category Scroll -->
<div class="xl:hidden bg-black text-white overflow-x-auto whitespace-nowrap scrollbar-hide py-3 px-4 border-b border-white/5 sticky top-0 z-40">
    <div class="flex gap-6 items-center">
        @foreach($megaMenuData as $key => $category)
            <a href="{{ route('category.show', $key) }}" class="text-[10px] font-bold uppercase tracking-widest {{ $key === 'sale' ? 'text-red-500' : '' }}">
                {{ $category['label'] }}
            </a>
        @endforeach
    </div>
</div>

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