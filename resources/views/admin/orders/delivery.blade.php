@extends('layouts.admin')

@section('content')
<div class="space-y-gutter">
    <!-- Header -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Logistics Hub</h2>
            <p class="font-body-md text-on-surface-variant text-label-md uppercase tracking-widest italic">Rider & Shipment Management</p>
        </div>
        <div class="flex gap-4">
            <button class="bg-white border border-outline-variant px-6 py-2.5 rounded-xl font-label-md text-sm hover:border-primary transition-all">Assign Riders</button>
            <button class="bg-primary text-white px-6 py-2.5 rounded-xl font-label-md hover:shadow-lg transition-all">Track Fleet</button>
        </div>
    </div>

    <!-- Logistics KPI -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <div class="glass-card p-8 rounded-full border border-outline-variant/30 flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[32px]">pending_actions</span>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-on-surface-variant tracking-[0.2em] mb-1">Awaiting Pickup</p>
                <h3 class="text-3xl font-headline-sm">{{ $stats['pending'] }}</h3>
            </div>
        </div>
        <div class="glass-card p-8 rounded-full border border-outline-variant/30 flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-primary-container/20 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[32px]">local_shipping</span>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-on-surface-variant tracking-[0.2em] mb-1">In Transit</p>
                <h3 class="text-3xl font-headline-sm">{{ $stats['shipped'] }}</h3>
            </div>
        </div>
        <div class="glass-card p-8 rounded-full border border-outline-variant/30 flex items-center gap-6 border-green-500/20 bg-green-500/5">
            <div class="w-16 h-16 rounded-full bg-green-500/10 flex items-center justify-center text-green-600">
                <span class="material-symbols-outlined text-[32px]">verified</span>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-on-surface-variant tracking-[0.2em] mb-1">Successfully Delivered</p>
                <h3 class="text-3xl font-headline-sm">{{ $stats['delivered'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Active Shipments Table -->
    <div class="glass-card rounded-full border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-low">
            <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em]">Real-time Shipment Tracker</h4>
            <div class="flex gap-2">
                <input type="text" placeholder="Search tracking ID..." class="bg-white border border-outline-variant px-4 py-1.5 rounded-full text-xs outline-none focus:ring-1 focus:ring-primary w-64"/>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-lowest text-on-surface-variant">
                    <tr>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Tracking ID</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Recipient</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Destination</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Progress</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 italic font-body-md">
                    @foreach($orders as $order)
                    <tr class="hover:bg-primary-container/5 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-on-surface tracking-tighter">NIFFER-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[9px] text-on-surface-variant uppercase font-bold tabular-nums">{{ $order->created_at->format('M d, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-outline-variant/20 flex items-center justify-center text-xs font-bold text-outline">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-on-surface">{{ $order->user->name }}</span>
                                    <span class="text-[10px] text-on-surface-variant group-hover:text-primary transition-colors cursor-pointer">{{ $order->user->phone }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-xs text-on-surface-variant truncate max-w-[200px]">
                            Dar es Salaam, {{ explode(',', $order->shipping_address ?? 'Branch Pickup')[0] }}
                        </td>
                        <td class="px-8 py-6">
                            <div class="w-32">
                                <div class="flex justify-between items-center mb-1.5 px-0.5">
                                    @php 
                                        $progress = match($order->status) {
                                            'pending' => 10,
                                            'packed' => 40,
                                            'shipped' => 70,
                                            'delivered' => 100,
                                            default => 0
                                        };
                                    @endphp
                                    <span class="text-[9px] uppercase font-bold text-outline italic tracking-widest">{{ $progress }}%</span>
                                    <span class="material-symbols-outlined text-[10px] {{ $progress == 100 ? 'text-green-600' : 'text-primary' }}">
                                        {{ $progress == 100 ? 'verified' : 'auto_awesome' }}
                                    </span>
                                </div>
                                <div class="h-1 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full {{ $progress == 100 ? 'bg-green-500' : 'bg-primary' }} transition-all duration-1000" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $statusStyle = match($order->status) {
                                    'pending' => 'bg-secondary-container/10 text-secondary border-secondary/20',
                                    'packed' => 'bg-primary-container/10 text-primary border-primary/20',
                                    'shipped' => 'bg-primary text-white border-primary',
                                    'delivered' => 'bg-green-500 text-white border-green-500',
                                    default => 'bg-outline-variant text-on-surface-variant border-outline-variant/30'
                                };
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-[9px] uppercase font-bold border {{ $statusStyle }} italic shadow-sm">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 px-margin-mobile">
                                <button class="p-2 hover:bg-primary/10 rounded-full transition-colors order-1"><span class="material-symbols-outlined text-[18px] text-outline group-hover:text-primary transition-colors">edit</span></button>
                                <button class="p-2 hover:bg-error/10 rounded-full transition-colors order-2"><span class="material-symbols-outlined text-[18px] text-outline group-hover:text-error transition-colors">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-outline-variant/20 bg-surface-container-lowest">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
