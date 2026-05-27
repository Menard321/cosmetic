<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Enterprise Admin - Angels Beauty</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
<link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
</head>
<body class="bg-surface font-body-md text-on-surface">
<!-- SideNavBar (Authority Source: JSON) -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container border-r border-outline-variant flex flex-col py-stack-md z-50">
<div class="px-6 mb-10">
<h1 class="font-headline-sm text-headline-sm text-primary">Angels Admin</h1>
<p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Enterprise Portal</p>
</div>
    <nav class="flex-grow space-y-2">
        <!-- Active Item: Sales Dashboard -->
        <a class="{{ request()->routeIs('admin.page') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} font-semibold rounded-xl mx-2 px-4 py-3 flex items-center gap-3 active:scale-98 transition-all" href="{{ route('admin.page') }}">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-label-md text-label-md">Sales Dashboard</span>
        </a>
        <a class="{{ request()->routeIs('admin.orders.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all active:scale-98" href="{{ route('admin.orders.index') }}">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span class="font-label-md text-label-md">Order Management</span>
        </a>
        <a class="{{ request()->routeIs('admin.customers.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all active:scale-98" href="{{ route('admin.customers.index') }}">
            <span class="material-symbols-outlined">groups</span>
            <span class="font-label-md text-label-md">Customer CRM</span>
        </a>
        <a class="{{ request()->routeIs('admin.products.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all active:scale-98" href="{{ route('admin.products.index') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-label-md text-label-md">Product Catalog</span>
        </a>
        <a class="{{ request()->routeIs('admin.vendors.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all active:scale-98" href="#">
            <span class="material-symbols-outlined">handshake</span>
            <span class="font-label-md text-label-md">Vendor Management</span>
        </a>
        <a class="{{ request()->routeIs('admin.inventory.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all active:scale-98" href="{{ route('admin.inventory.index') }}">
            <span class="material-symbols-outlined">warehouse</span>
            <span class="font-label-md text-label-md">Inventory Control</span>
        </a>
        <a class="{{ request()->routeIs('admin.consultations.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all active:scale-98" href="{{ route('admin.consultations.index') }}">
            <span class="material-symbols-outlined">spa</span>
            <span class="font-label-md text-label-md flex-1">Consultations</span>
            @php $pendingCount = \App\Models\Consultation::where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="bg-primary text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold">{{ $pendingCount }}</span>
            @endif
        </a>
    </nav>
    <div class="mt-auto border-t border-outline-variant pt-4">
        <a class="{{ request()->routeIs('profile.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-label-md text-label-md">Settings</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-[calc(100%-16px)] text-left text-on-surface-variant hover:bg-surface-variant/50 rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all active:scale-98" type="submit">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-label-md text-label-md">Log Out</span>
            </button>
        </form>
    </div>
</aside>
<!-- TopNavBar (Authority Source: JSON) -->
<header class="fixed top-0 left-64 right-0 bg-surface/95 backdrop-blur-md border-b border-outline-variant z-40 flex justify-between items-center px-gutter py-2">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
<input class="w-full bg-surface-container-high border-none rounded-full py-2 pl-10 pr-4 font-body-md text-body-md focus:ring-2 focus:ring-primary-container" placeholder="Search enterprise data..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="p-2 hover:bg-surface-container-high rounded-full transition-all duration-200">
<span class="material-symbols-outlined text-secondary" data-icon="notifications">notifications</span>
</button>
<button class="p-2 hover:bg-surface-container-high rounded-full transition-all duration-200">
<span class="material-symbols-outlined text-secondary" data-icon="apps">apps</span>
</button>
<div class="flex items-center gap-3 ml-2 pl-4 border-l border-outline-variant">
<span class="text-right hidden sm:block">
<p class="font-label-md text-label-md text-on-surface">{{ auth()->user()->name }}</p>
<p class="text-[10px] text-on-surface-variant uppercase">{{ auth()->user()->getRoleNames()->first() }}</p>
</span>
<span class="material-symbols-outlined text-secondary text-3xl" data-icon="account_circle">account_circle</span>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 pb-stack-lg px-margin-desktop max-w-container-max mx-auto">
@yield('content')
</main>
<!-- Footer (Authority Source: JSON) -->
<footer class="ml-64 bg-surface border-t border-outline-variant py-stack-lg">
<div class="grid grid-cols-2 md:grid-cols-4 gap-gutter px-margin-desktop max-w-container-max mx-auto">
<div>
<h5 class="font-headline-sm text-headline-sm text-on-surface mb-4">Angels Beauty</h5>
<p class="font-body-md text-on-surface-variant text-label-md">© 2023 Angels Beauty Tanzania. All Rights Reserved.</p>
</div>
<div>
<h6 class="font-label-md text-label-md text-primary uppercase mb-4">Company</h6>
<ul class="space-y-2">
<li><a class="font-body-md text-secondary hover:text-primary hover:underline transition-all" href="#">Brand Story</a></li>
<li><a class="font-body-md text-secondary hover:text-primary hover:underline transition-all" href="#">Shipping Policy</a></li>
</ul>
</div>
<div>
<h6 class="font-label-md text-label-md text-primary uppercase mb-4">Merchant Help</h6>
<ul class="space-y-2">
<li><a class="font-body-md text-secondary hover:text-primary hover:underline transition-all" href="#">M-Pesa Guide</a></li>
<li><a class="font-body-md text-secondary hover:text-primary hover:underline transition-all" href="#">Airtel Money</a></li>
<li><a class="font-body-md text-secondary hover:text-primary hover:underline transition-all" href="#">Tigo Pesa</a></li>
</ul>
</div>
<div>
<h6 class="font-label-md text-label-md text-primary uppercase mb-4">Connect</h6>
<ul class="space-y-2">
<li><a class="font-body-md text-secondary hover:text-primary hover:underline transition-all" href="#">Instagram</a></li>
</ul>
</div>
</div>
</footer>
</body></html>