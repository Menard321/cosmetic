<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Dashboard - Silk Beauty</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
                        "headline-md": ["Playfair Display"],
                        "label-md": ["Inter"],
                        "label-sm": ["Inter"]
                }
              },
            },
          }
    </script>
</head>
<body class="bg-surface font-body-md text-on-surface">
    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container border-r border-outline-variant flex flex-col py-stack-md z-50">
        <div class="px-6 mb-10">
            <h1 class="font-headline-sm text-headline-sm text-primary">Silk Beauty</h1>
            <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">My Account</p>
        </div>
        
        <nav class="flex-grow space-y-2">
            <a class="{{ request()->routeIs('dashboard') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} font-semibold rounded-xl mx-2 px-4 py-3 flex items-center gap-3 active:scale-98 transition-all" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-label-md">Overview</span>
            </a>
            <a class="{{ request()->routeIs('customer.orders') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all" href="{{ route('customer.orders') }}">
                <span class="material-symbols-outlined">shopping_bag</span>
                <span class="font-label-md">My Orders</span>
            </a>
            <a class="{{ request()->routeIs('customer.wishlist') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all" href="{{ route('customer.wishlist') }}">
                <span class="material-symbols-outlined">favorite</span>
                <span class="font-label-md">Wishlist</span>
            </a>
            <a class="{{ request()->routeIs('customer.addresses') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all" href="{{ route('customer.addresses') }}">
                <span class="material-symbols-outlined">location_on</span>
                <span class="font-label-md">Saved Addresses</span>
            </a>
            <a class="{{ request()->routeIs('customer.notifications') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all" href="{{ route('customer.notifications') }}">
                <span class="material-symbols-outlined">notifications</span>
                <span class="font-label-md">Notifications</span>
            </a>
            <a class="{{ request()->routeIs('customer.loyalty') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all" href="{{ route('customer.loyalty') }}">
                <span class="material-symbols-outlined">card_membership</span>
                <span class="font-label-md">Loyalty Points</span>
            </a>
        </nav>

        <div class="mt-auto border-t border-outline-variant pt-4">
            <a class="text-on-surface-variant hover:bg-surface-variant/50 rounded-xl mx-2 px-4 py-3 flex items-center gap-3 hover:translate-x-1 transition-all" href="{{ route('profile.edit') }}">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-label-md text-label-md">Profile Settings</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-on-surface-variant hover:bg-surface-variant/50 rounded-xl mx-0 px-6 py-3 flex items-center gap-3 hover:translate-x-1 transition-all">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-label-md text-label-md">Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- TopHeader -->
    <header class="fixed top-0 left-64 right-0 bg-surface/95 backdrop-blur-md border-b border-outline-variant z-40 flex justify-between items-center px-gutter py-2">
        <div class="flex items-center gap-4 flex-1">
            <h2 class="font-headline-sm text-headline-sm text-on-surface ml-4">Hello, {{ auth()->user()->name }}</h2>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 p-2 bg-primary-container/10 rounded-full border border-primary-container/20">
                <span class="material-symbols-outlined text-primary text-sm">stars</span>
                <span class="text-label-sm text-primary font-bold pr-2">250 Points</span>
            </div>
            <div class="flex items-center gap-3 ml-2 pl-4 border-l border-outline-variant">
                <span class="material-symbols-outlined text-secondary text-3xl">account_circle</span>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="ml-64 pt-24 pb-stack-lg px-margin-desktop max-w-container-max mx-auto">
        {{ $slot }}
    </main>
</body>
</html>
