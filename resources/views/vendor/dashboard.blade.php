@extends('layouts.admin')

@section('content')
<!-- Header -->
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Merchant Headquarters</h2>
        <p class="font-body-md text-on-surface-variant">Track your product performance and manage pending customer orders.</p>
    </div>
</div>

<!-- Vendor KPIs -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-stack-lg">
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30">
        <p class="font-label-md text-on-surface-variant uppercase tracking-wider">My Products</p>
        <h3 class="font-headline-sm text-headline-sm mt-1">12</h3>
    </div>
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30">
        <p class="font-label-md text-on-surface-variant uppercase tracking-wider">Today's Sales</p>
        <h3 class="font-headline-sm text-headline-sm mt-1">450k TZS</h3>
    </div>
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30">
        <p class="font-label-md text-on-surface-variant uppercase tracking-wider">Avg. Rating</p>
        <h3 class="font-headline-sm text-headline-sm mt-1 text-primary">4.8 ★</h3>
    </div>
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30">
        <p class="font-label-md text-on-surface-variant uppercase tracking-wider">Pending Orders</p>
        <h3 class="font-headline-sm text-headline-sm mt-1 text-error">5</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
    <!-- Product Inventory Status -->
    <div class="lg:col-span-2 glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
            <h4 class="font-label-md text-on-surface uppercase font-bold">My Product Inventory</h4>
            <button class="bg-primary text-white px-4 py-2 rounded-lg font-label-sm">+ Add New</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low text-on-surface-variant font-label-sm">
                    <tr>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="px-6 py-4 font-medium">Glow Essence Serum</td>
                        <td class="px-6 py-4">85,000 TZS</td>
                        <td class="px-6 py-4">4 Units</td>
                        <td class="px-6 py-4"><span class="text-error font-bold">Low Stock</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payout Information -->
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30 shadow-sm">
        <h4 class="font-label-md text-on-surface uppercase font-bold mb-6">Payout Balance</h4>
        <div class="p-6 bg-primary-container/10 rounded-2xl border border-primary/20 text-center mb-6">
            <p class="text-label-sm text-on-surface-variant uppercase">Available for Withdrawal</p>
            <h2 class="text-headline-md font-bold text-primary mt-2">1,240,000 TZS</h2>
        </div>
        <button class="w-full bg-on-background text-on-secondary py-4 rounded-xl font-label-md uppercase tracking-widest hover:opacity-90">Request Payout</button>
        <p class="text-[10px] text-center text-on-surface-variant mt-4">Next scheduled payout: May 25, 2026</p>
    </div>
</div>
@endsection
