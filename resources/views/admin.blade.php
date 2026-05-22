@extends('layouts.admin')

@section('content')
<!-- Header -->
<div class="flex justify-between items-end mb-stack-lg">
<div>
<h2 class="font-headline-md text-headline-md text-on-surface">Executive Overview</h2>
<p class="font-body-md text-on-surface-variant">Welcome back. Here's what's happening with Jolene Beauty today.</p>
</div>
<div class="flex gap-stack-sm">
<button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-xl hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined text-body-md" data-icon="calendar_today">calendar_today</span>
<span class="font-label-md text-label-md">Last 30 Days</span>
</button>
<button class="flex items-center gap-2 px-4 py-2 bg-on-background text-on-secondary rounded-xl hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined text-body-md" data-icon="download">download</span>
<span class="font-label-md text-label-md">Export Report</span>
</button>
</div>
</div>
<!-- KPI Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-stack-lg">
<!-- Revenue -->
<div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary-container/20 rounded-lg">
<span class="material-symbols-outlined text-primary" data-icon="payments">payments</span>
</div>
<span class="flex items-center gap-1 text-primary font-bold text-label-sm">
                        +12.5% <span class="material-symbols-outlined text-[14px]" data-icon="trending_up">trending_up</span>
</span>
</div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Total Revenue</p>
<h3 class="font-headline-sm text-headline-sm mt-1">{{ number_format($totalRevenue) }} TZS</h3>
</div>
<!-- Orders -->
<div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-secondary-container rounded-lg">
<span class="material-symbols-outlined text-secondary" data-icon="shopping_cart">shopping_cart</span>
</div>
<span class="flex items-center gap-1 text-primary font-bold text-label-sm">
                        +8.2% <span class="material-symbols-outlined text-[14px]" data-icon="trending_up">trending_up</span>
</span>
</div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Total Orders</p>
<h3 class="font-headline-sm text-headline-sm mt-1">{{ number_format($totalOrders) }}</h3>
</div>
<!-- Active Vendors -->
<div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-tertiary-container/30 rounded-lg">
<span class="material-symbols-outlined text-tertiary" data-icon="storefront">storefront</span>
</div>
<span class="flex items-center gap-1 text-secondary font-bold text-label-sm">
                        Stable <span class="material-symbols-outlined text-[14px]" data-icon="horizontal_rule">horizontal_rule</span>
</span>
</div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Active Vendors</p>
<h3 class="font-headline-sm text-headline-sm mt-1">{{ number_format($activeVendors) }}</h3>
</div>
<!-- Conversion Rate -->
<div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-outline-variant/20 rounded-lg">
<span class="material-symbols-outlined text-outline" data-icon="ads_click">ads_click</span>
</div>
<span class="flex items-center gap-1 text-error font-bold text-label-sm">
                        -0.4% <span class="material-symbols-outlined text-[14px]" data-icon="trending_down">trending_down</span>
</span>
</div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Conversion Rate</p>
<h3 class="font-headline-sm text-headline-sm mt-1">3.24%</h3>
</div>
</div>
<!-- Middle Section: Chart & Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mb-stack-lg">
<!-- Sales Chart (Simulated Visual) -->
<div class="lg:col-span-2 glass-card p-6 rounded-xl border border-outline-variant/30 shadow-sm">
<div class="flex justify-between items-center mb-8">
<h4 class="font-label-md text-label-md text-on-surface uppercase font-bold">Revenue Performance</h4>
<div class="flex gap-4">
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-primary"></span>
<span class="text-label-sm text-on-surface-variant">This Month</span>
</div>
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-secondary-fixed-dim"></span>
<span class="text-label-sm text-on-surface-variant">Last Month</span>
</div>
</div>
</div>
<div class="h-64 w-full relative flex items-end gap-2 px-2 border-b border-outline-variant/30">
<!-- Simulated Bar Chart for editorial look -->
<div class="flex-1 bg-primary/20 rounded-t-lg h-[40%] transition-all hover:bg-primary/40 group relative">
<div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-on-background text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">8.2M</div>
</div>
<div class="flex-1 bg-primary/20 rounded-t-lg h-[55%] transition-all hover:bg-primary/40 group relative"></div>
<div class="flex-1 bg-primary/20 rounded-t-lg h-[45%] transition-all hover:bg-primary/40 group relative"></div>
<div class="flex-1 bg-primary rounded-t-lg h-[85%] transition-all hover:bg-primary-container group relative">
<div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-on-background text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">15.4M</div>
</div>
<div class="flex-1 bg-primary/20 rounded-t-lg h-[60%] transition-all hover:bg-primary/40 group relative"></div>
<div class="flex-1 bg-primary/20 rounded-t-lg h-[70%] transition-all hover:bg-primary/40 group relative"></div>
<div class="flex-1 bg-primary/20 rounded-t-lg h-[50%] transition-all hover:bg-primary/40 group relative"></div>
</div>
<div class="flex justify-between mt-4 text-[10px] text-on-surface-variant uppercase tracking-tighter">
<span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
</div>
</div>
<!-- Recent Activity -->
<div class="glass-card p-6 rounded-xl border border-outline-variant/30 shadow-sm flex flex-col">
<h4 class="font-label-md text-label-md text-on-surface uppercase font-bold mb-6">Recent Activity</h4>
<div class="space-y-6 flex-grow overflow-y-auto">
<div class="flex gap-4">
<div class="relative">
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-xl" data-icon="person_add">person_add</span>
</div>
<span class="absolute bottom-0 right-0 w-3 h-3 bg-primary border-2 border-surface rounded-full"></span>
</div>
<div>
<p class="text-label-md font-semibold">New Vendor Approved</p>
<p class="text-label-sm text-on-surface-variant">Lulu Organics Arusha has been verified.</p>
<p class="text-[10px] text-outline mt-1 uppercase">2 Minutes ago</p>
</div>
</div>
<div class="flex gap-4">
<div class="w-10 h-10 rounded-full bg-error-container flex items-center justify-center">
<span class="material-symbols-outlined text-error text-xl" data-icon="warning">warning</span>
</div>
<div>
<p class="text-label-md font-semibold">Stock Alert</p>
<p class="text-label-sm text-on-surface-variant">Radiance Serum is below 10 units.</p>
<p class="text-[10px] text-outline mt-1 uppercase">45 Minutes ago</p>
</div>
</div>
<div class="flex gap-4">
<div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-secondary text-xl" data-icon="payments">payments</span>
</div>
<div>
<p class="text-label-md font-semibold">Payout Processed</p>
<p class="text-label-sm text-on-surface-variant">TZS 4.2M transferred to M-Pesa Business.</p>
<p class="text-[10px] text-outline mt-1 uppercase">2 Hours ago</p>
</div>
</div>
</div>
<button class="mt-6 text-primary font-label-md text-center hover:underline">View All Notifications</button>
</div>
</div>
<!-- Bottom Section: Tables & Inventory -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
<!-- Top Performing Vendors Table -->
<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
<div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
<h4 class="font-label-md text-label-md text-on-surface uppercase font-bold">Top Performing Vendors</h4>
<button class="text-primary font-label-sm">Full Rankings</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead class="bg-surface-container-low text-on-surface-variant font-label-sm">
<tr>
<th class="px-6 py-4 font-semibold uppercase tracking-wider">Vendor</th>
<th class="px-6 py-4 font-semibold uppercase tracking-wider">Sales (TZS)</th>
<th class="px-6 py-4 font-semibold uppercase tracking-wider">Growth</th>
<th class="px-6 py-4 font-semibold uppercase tracking-wider">Status</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/30">
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-lg bg-surface-variant overflow-hidden">
<img class="w-full h-full object-cover" data-alt="A macro shot of a luxury organic cosmetic brand logo embossed on a heavy glass bottle, sitting on a marble surface under soft golden hour lighting. The aesthetic is high-end, minimalist, and focuses on the tactile texture of premium packaging." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjX-hNuo7tTc9L3stpye6x6jXMdazyjbqJkQXnM18Oydh7QK5cA17eiCNO4sp6lke8-kqtKL9E3cmMLmuTaTm30J6Yq0IhTpIG0gfWtgdmPDOM0mwK7R70p4L0K5iupDvptm1av45ocxstwuIsEu6dem0botBJ-YteY_wnp1VtqIPcCIih2SyDjAl8tuwiaLgpvjkILZ6xv0T868a_wdDI6fi6TlI5Rg96f_KZF8q0n08fN0EcN30wvHtbjniq_sHzAbPJyYUlkQE"/>
</div>
<span class="text-label-md font-medium">Amani Skincare</span>
</div>
</td>
<td class="px-6 py-4 text-label-md">12,450,000</td>
<td class="px-6 py-4 text-primary font-bold text-label-sm">+18%</td>
<td class="px-6 py-4">
<span class="px-2 py-1 bg-primary-container/20 text-on-primary-container text-[10px] rounded uppercase font-bold">Elite</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-lg bg-surface-variant overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Close up of a botanical skincare brand logo featuring a gold leaf illustration against a deep charcoal background. The lighting is moody with high contrast, emphasizing a sense of exclusivity and premium botanical quality in a modern cosmetic context." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBqe5cuWhMwNBOdwhJogQjG9JyI4p8smCxbSxZOS8WqlW-OeHZt6uwKi8TWexG-jgbdZ0pWBZNtM0RnJVmXfDrPnj0V4y4co6tPCvtoLbN1mk0-9pR_RagWDD2moMaxujizYZkceehCr1OnlX7tFsRW8LumzbhuJAgMlDsyTwS82uXwmZWa2GfWqtED7Jb6qz_eX0zG54NsV7qUDZMnTd6C6ag_UO9Qm6WO-GWveifMFn8bH_00Wx4rrofNxXDEV5qNXZ_PpYmX0T8"/>
</div>
<span class="text-label-md font-medium">Zanzibar Botanicals</span>
</div>
</td>
<td class="px-6 py-4 text-label-md">8,900,000</td>
<td class="px-6 py-4 text-primary font-bold text-label-sm">+12%</td>
<td class="px-6 py-4">
<span class="px-2 py-1 bg-secondary-container text-on-secondary-container text-[10px] rounded uppercase font-bold">Rising</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Inventory Alerts -->
<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm">
<div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
<h4 class="font-label-md text-label-md text-on-surface uppercase font-bold">Critical Inventory Alerts</h4>
<span class="bg-error text-white text-[10px] px-2 py-1 rounded-full font-bold">{{ $urgentAlerts->count() }} Urgent</span>
</div>
<div class="p-6 space-y-4">
@foreach($urgentAlerts as $alert)
<div class="flex items-center justify-between p-4 bg-error-container/10 border border-error/20 rounded-xl">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-surface-variant overflow-hidden">
<img class="w-full h-full object-cover" data-alt="{{ $alert->name }}" src="{{ $alert->image_url }}"/>
</div>
<div>
<p class="text-label-md font-bold">{{ $alert->name }}</p>
<p class="text-label-sm text-error font-medium">Stock: {{ $alert->stock_quantity }} Units Left</p>
</div>
</div>
<a href="{{ route('admin.products.edit', $alert->id) }}" class="bg-on-background text-on-secondary px-4 py-2 rounded-lg font-label-sm hover:opacity-90">Restock Now</a>
</div>
@endforeach
@if($urgentAlerts->isEmpty())
<p class="text-label-md text-secondary text-center">No critical stock alerts.</p>
@endif
</div>
</div>
</div>
@endsection