@extends('layouts.admin')

@section('content')
<!-- Header -->
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Rider Logistics Portal</h2>
        <p class="font-body-md text-on-surface-variant">Manage your assigned deliveries and explore available requests in Dar Es Salaam.</p>
    </div>
</div>

<!-- Logistics Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-stack-lg">
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30">
        <p class="font-label-md text-on-surface-variant uppercase tracking-wider">My Active Tasks</p>
        <h3 class="font-headline-sm text-headline-sm mt-1 text-primary">{{ $myOrders->where('delivery_status', 'out_for_delivery')->count() }}</h3>
    </div>
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30">
        <p class="font-label-md text-on-surface-variant uppercase tracking-wider">Completed Today</p>
        <h3 class="font-headline-sm text-headline-sm mt-1 text-secondary">{{ $myOrders->where('delivery_status', 'delivered')->where('updated_at', '>=', now()->startOfDay())->count() }}</h3>
    </div>
    <div class="glass-card p-6 rounded-xl border border-outline-variant/30">
        <p class="font-label-md text-on-surface-variant uppercase tracking-wider">Available Pool</p>
        <h3 class="font-headline-sm text-headline-sm mt-1 text-tertiary">{{ $availableOrders->count() }}</h3>
    </div>
</div>

<!-- Orders Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
    <!-- Available for Pickup -->
    <div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low">
            <h4 class="font-label-md text-on-surface uppercase font-bold">Available For Pickup</h4>
        </div>
        <div class="p-6 space-y-4">
            @forelse($availableOrders as $order)
                <div class="p-4 border border-outline-variant/50 rounded-xl hover:bg-surface-container-low transition-colors">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-bold text-label-md">Order #{{ $order->id }}</span>
                        <span class="text-primary font-bold">TZS {{ number_format($order->total_amount) }}</span>
                    </div>
                    <p class="text-label-sm text-on-surface-variant mb-4">
                        <span class="material-symbols-outlined text-[14px] align-middle" data-icon="location_on">location_on</span> 
                        {{ $order->delivery_address ?? 'Dar Es Salaam, Tanzania' }}
                    </p>
                    <button class="w-full bg-on-background text-on-secondary py-2 rounded-lg font-label-md hover:opacity-90 transition-opacity">Claim Delivery</button>
                </div>
            @empty
                <p class="text-center text-on-surface-variant py-4">Searching for new requests...</p>
            @endforelse
        </div>
    </div>

    <!-- My Assigned Tasks -->
    <div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">
        <div class="p-6 border-b border-outline-variant/30 bg-primary-container/10">
            <h4 class="font-label-md text-primary uppercase font-bold">My Active Deliveries</h4>
        </div>
        <div class="p-6 space-y-6 flex-grow">
            @forelse($myOrders as $order)
                <div class="flex gap-4 p-4 bg-surface-container rounded-xl">
                    <div class="p-3 bg-white rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-2xl" data-icon="local_shipping">local_shipping</span>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between">
                            <p class="font-bold">#{{ $order->id }} - {{ $order->customer_name }}</p>
                            <span class="text-[10px] px-2 py-1 bg-primary text-white rounded uppercase">{{ $order->delivery_status }}</span>
                        </div>
                        <p class="text-label-sm text-on-surface-variant mt-1">{{ $order->phone }}</p>
                        <div class="flex gap-2 mt-4">
                            <button class="flex-1 bg-white border border-outline py-2 rounded-lg text-label-sm hover:bg-surface-variant/20">Update Status</button>
                            <button class="px-4 bg-secondary-container text-on-secondary-container py-2 rounded-lg text-label-sm">Map</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 opacity-50">
                    <span class="material-symbols-outlined text-4xl mb-2" data-icon="pending_actions">pending_actions</span>
                    <p class="text-label-md">No tasks assigned yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
