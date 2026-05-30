<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Enterprise Admin - Niffer Cosmetic</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
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
<aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container border-r border-outline-variant flex flex-col py-stack-md z-50">
    <div class="px-6 mb-10">
        <h1 class="font-headline-sm text-headline-sm text-primary">Niffer Admin</h1>
        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Enterprise Portal</p>
    </div>
    <nav class="flex-grow space-y-1 overflow-y-auto custom-scrollbar px-2">
        <div class="pt-2 pb-1 px-4 text-[10px] uppercase font-bold text-outline tracking-[0.2em]">Core Systems</div>
        <a class="{{ request()->routeIs('admin.page') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 active:scale-98 transition-all" href="{{ route('admin.page') }}">
            <span class="material-symbols-outlined text-[20px]">dashboard</span>
            <span class="font-label-md text-label-md">Sales Dashboard</span>
        </a>
        <a class="{{ request()->routeIs('admin.analytics.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.analytics.index') }}">
            <span class="material-symbols-outlined text-[20px]">analytics</span>
            <span class="font-label-md text-label-md">Analytics & Reports</span>
        </a>

        <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold text-outline tracking-[0.2em]">Operations</div>
        <div class="space-y-0.5">
            <a class="{{ request()->routeIs('admin.orders.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.orders.index') }}">
                <span class="material-symbols-outlined text-[20px]">shopping_basket</span>
                <span class="font-label-md text-label-md">Order Management</span>
            </a>
            <a class="{{ request()->routeIs('admin.delivery.index') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.delivery.index') }}">
                <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                <span class="font-label-md text-label-md">Delivery & Riders</span>
            </a>
        </div>

        <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold text-outline tracking-[0.2em]">Catalog</div>
        <div class="space-y-0.5">
            <a class="{{ request()->routeIs('admin.products.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.products.index') }}">
                <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                <span class="font-label-md text-label-md">Product Catalog</span>
            </a>
            <a class="{{ request()->routeIs('admin.inventory.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.inventory.index') }}">
                <span class="material-symbols-outlined text-[20px]">warehouse</span>
                <span class="font-label-md text-label-md">Inventory Control</span>
            </a>
        </div>

        <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold text-outline tracking-[0.2em]">CRM</div>
        <div class="space-y-0.5">
            <a class="{{ request()->routeIs('admin.customers.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.customers.index') }}">
                <span class="material-symbols-outlined text-[20px]">group</span>
                <span class="font-label-md text-label-md">Customer CRM</span>
            </a>
            <a class="{{ request()->routeIs('admin.consultations.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.consultations.index') }}">
                <span class="material-symbols-outlined text-[20px]">spa</span>
                <span class="font-label-md text-label-md">Consultations</span>
            </a>
            <a class="{{ request()->routeIs('admin.notifications.index') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.notifications.index') }}">
                <span class="material-symbols-outlined text-[20px]">campaign</span>
                <span class="font-label-md text-label-md">Notification Hub</span>
            </a>
            <a class="{{ request()->routeIs('admin.loyalty.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.loyalty.index') }}">
                <span class="material-symbols-outlined text-[20px] text-primary">diamond</span>
                <span class="font-label-md text-label-md font-bold">Loyalty Intelligence</span>
            </a>
        </div>

        <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold text-outline tracking-[0.2em]">Employee Management</div>
        <div class="space-y-0.5">
            <a class="{{ request()->routeIs('admin.ems.dashboard') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.dashboard') }}">
                <span class="material-symbols-outlined text-[20px]">badge</span>
                <span class="font-label-md text-label-md">EMS Dashboard</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.employees.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.employees.index') }}">
                <span class="material-symbols-outlined text-[20px]">groups</span>
                <span class="font-label-md text-label-md">Staff Directory</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.attendance.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.attendance.index') }}">
                <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                <span class="font-label-md text-label-md">Attendance</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.payroll.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.payroll.index') }}">
                <span class="material-symbols-outlined text-[20px]">payments</span>
                <span class="font-label-md text-label-md">Payroll</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.leaves.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.leaves.index') }}">
                <span class="material-symbols-outlined text-[20px]">beach_access</span>
                <span class="font-label-md text-label-md">Leave Requests</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.performance.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.performance.index') }}">
                <span class="material-symbols-outlined text-[20px]">insights</span>
                <span class="font-label-md text-label-md">Performance</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.shifts.index') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.shifts.index') }}">
                <span class="material-symbols-outlined text-[20px]">schedule</span>
                <span class="font-label-md text-label-md">Shift Management</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.shifts.assignments') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.shifts.assignments') }}">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span class="font-label-md text-label-md">Shift Assignments</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.transfers.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.transfers.index') }}">
                <span class="material-symbols-outlined text-[20px]">swap_horiz</span>
                <span class="font-label-md text-label-md">Staff Transfers</span>
            </a>
            <a class="{{ request()->routeIs('admin.ems.reports.index') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('admin.ems.reports.index') }}">
                <span class="material-symbols-outlined text-[20px]">analytics</span>
                <span class="font-label-md text-label-md">HR Analytics</span>
            </a>
        </div>

        <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold text-outline tracking-[0.2em]">Intelligence</div>
        <a href="javascript:void(0)" onclick="toggleAiChat()" class="text-on-surface-variant hover:bg-surface-variant/50 rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all mb-8">
            <span class="material-symbols-outlined text-[20px] text-primary">auto_awesome</span>
            <span class="font-label-md text-label-md text-primary font-bold">AI Beauty Assistant</span>
        </a>
    </nav>
    <div class="mt-auto border-t border-outline-variant/30 pt-4 px-2">
        <a class="{{ request()->routeIs('profile.*') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-variant/50' }} rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined text-[20px]">settings</span>
            <span class="font-label-md text-label-md">System Settings</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left text-on-surface-variant hover:bg-error/10 hover:text-error rounded-xl px-4 py-2.5 flex items-center gap-3 transition-all" type="submit">
                <span class="material-symbols-outlined text-[20px]">logout</span>
                <span class="font-label-md text-label-md">Log Out</span>
            </button>
        </form>
    </div>
</aside>

<header class="fixed top-0 left-64 right-0 bg-surface/95 backdrop-blur-md border-b border-outline-variant z-40 flex justify-between items-center px-gutter py-2">
    <div class="flex items-center gap-4 flex-1">
        <div class="relative w-full max-w-md">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input class="w-full bg-surface-container-high border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary-container" placeholder="Search enterprise data..." type="text"/>
        </div>
    </div>
    <div class="flex items-center gap-4 px-6">
        <div class="flex items-center gap-3 border-l border-outline-variant pl-4">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-on-surface">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-on-surface-variant uppercase font-bold">{{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
            <span class="material-symbols-outlined text-secondary text-3xl">account_circle</span>
        </div>
    </div>
</header>

<main class="ml-64 pt-24 pb-10 px-10 max-w-7xl mx-auto">
    @yield('content')
</main>

<footer class="ml-64 bg-surface border-t border-outline-variant py-10 px-10">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
        <div class="col-span-2">
            <h5 class="font-headline-sm text-xl text-on-surface mb-4">Niffer Cosmetic</h5>
            <p class="text-sm text-on-surface-variant max-w-md italic">Transforming beauty across Tanzania through professional skincare, luxury retail, and advanced enterprise technology.</p>
        </div>
        <div>
            <h6 class="text-[10px] font-bold text-primary uppercase mb-4 tracking-widest">Support</h6>
            <ul class="space-y-2 text-xs font-bold text-on-surface-variant">
                <li>Help Center</li>
                <li>API Documentation</li>
            </ul>
        </div>
        <div>
            <h6 class="text-[10px] font-bold text-primary uppercase mb-4 tracking-widest">Connect</h6>
            <ul class="space-y-2 text-xs font-bold text-on-surface-variant">
                <li>Instagram</li>
                <li>WhatsApp</li>
            </ul>
        </div>
    </div>
</footer>

{{-- AI Assistant Chat Window --}}
<div id="ai-chat-window" class="fixed bottom-6 right-6 w-96 bg-white rounded-3xl shadow-2xl border border-outline-variant/30 flex flex-col z-[100] transform translate-y-[120%] opacity-0 transition-all duration-500 overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-on-background to-primary p-5 text-white flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md">
                <span class="material-symbols-outlined text-white text-[20px]">auto_awesome</span>
            </div>
            <div>
                <p class="font-bold text-sm leading-tight">Niffer AI Assistant</p>
                <p class="text-[9px] uppercase font-black tracking-widest opacity-70">Enterprise Intelligence</p>
            </div>
        </div>
        <button onclick="toggleAiChat()" class="w-8 h-8 flex items-center justify-center hover:bg-white/10 rounded-lg transition-colors">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>

    {{-- Messages Area --}}
    <div id="ai-messages" class="h-[400px] overflow-y-auto p-5 space-y-4 bg-surface-container-lowest/50 custom-scrollbar">
        <div class="flex gap-3">
            <div class="w-8 h-8 rounded-lg bg-primary-container flex-shrink-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary-container text-[14px]">smart_toy</span>
            </div>
            <div class="bg-white border border-outline-variant/20 p-3 rounded-2xl rounded-tl-none shadow-sm text-xs leading-relaxed text-on-surface">
                Greetings, {{ auth()->user()->name }}. I am your Niffer Enterprise Assistant. How can I assist you with product insights, inventory status, or customer analysis today?
            </div>
        </div>
    </div>

    {{-- Input Area --}}
    <div class="p-4 border-t border-outline-variant/20 bg-white">
        <form id="ai-chat-form" class="relative">
            <textarea id="ai-input" rows="1" class="w-full bg-surface-container-low border-none rounded-2xl py-3 pl-4 pr-12 text-sm focus:ring-2 focus:ring-primary/20 resize-none overflow-hidden" placeholder="Type your inquiry..."></textarea>
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-on-background text-white rounded-xl flex items-center justify-center hover:bg-primary transition-all shadow-md">
                <span class="material-symbols-outlined text-[16px]">send</span>
            </button>
        </form>
    </div>
</div>

<script>
    function toggleAiChat() {
        const window = document.getElementById('ai-chat-window');
        const isOpen = window.classList.contains('translate-y-0');
        
        if (isOpen) {
            window.classList.add('translate-y-[120%]', 'opacity-0');
            window.classList.remove('translate-y-0', 'opacity-100');
        } else {
            window.classList.remove('translate-y-[120%]', 'opacity-0');
            window.classList.add('translate-y-0', 'opacity-100');
        }
    }

    const aiForm = document.getElementById('ai-chat-form');
    const aiInput = document.getElementById('ai-input');
    const aiMessages = document.getElementById('ai-messages');

    aiInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    aiForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = aiInput.value.trim();
        if (!message) return;

        // Add user message
        appendMessage('user', message);
        aiInput.value = '';
        aiInput.style.height = 'auto';

        // Typing indicator
        const typingId = 'typing-' + Date.now();
        appendMessage('ai', 'Thinking...', typingId);

        try {
            const response = await fetch('{{ route("beauty-ai.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            document.getElementById(typingId).remove();
            
            if (data.reply) {
                appendMessage('ai', data.reply);
            } else {
                appendMessage('ai', 'I apologize, I am experiencing a temporary connection issue. Please try again.');
            }
        } catch (error) {
            document.getElementById(typingId).remove();
            appendMessage('ai', 'Connection error. Please ensure the AI service is active.');
        }
    });

    function appendMessage(role, text, id = null) {
        const div = document.createElement('div');
        div.className = 'flex gap-3 ' + (role === 'user' ? 'flex-row-reverse' : '');
        if (id) div.id = id;

        const icon = role === 'user' ? 'person' : 'smart_toy';
        const color = role === 'user' ? 'bg-surface-container-highest' : 'bg-primary-container';
        const textColor = role === 'user' ? 'text-on-surface' : 'text-on-primary-container';
        const radius = role === 'user' ? 'rounded-tr-none' : 'rounded-tl-none';

        div.innerHTML = `
            <div class="w-8 h-8 rounded-lg ${color} flex-shrink-0 flex items-center justify-center">
                <span class="material-symbols-outlined ${textColor} text-[14px]">${icon}</span>
            </div>
            <div class="bg-white border border-outline-variant/20 p-3 rounded-2xl ${radius} shadow-sm text-xs leading-relaxed text-on-surface max-w-[80%]">
                ${text.replace(/\n/g, '<br>')}
            </div>
        `;
        aiMessages.appendChild(div);
        aiMessages.scrollTop = aiMessages.scrollHeight;
    }
</script>
</body></html>