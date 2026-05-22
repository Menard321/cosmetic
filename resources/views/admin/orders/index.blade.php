@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Order Management</h2>
        <p class="font-body-md text-on-surface-variant">Oversee all customer purchases and logistics.</p>
    </div>
</div>

<!-- Filters -->
<div class="glass-card p-6 rounded-xl border border-outline-variant/30 mb-stack-lg">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="text-[10px] uppercase font-bold text-on-surface-variant mb-1 block">Status</label>
            <select name="status" class="form-input-premium w-full text-sm">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="text-[10px] uppercase font-bold text-on-surface-variant mb-1 block">Customer Name</label>
            <input type="text" name="customer" value="{{ request('customer') }}" class="form-input-premium w-full text-sm" placeholder="Search customer...">
        </div>
        <div>
            <label class="text-[10px] uppercase font-bold text-on-surface-variant mb-1 block">Order Date</label>
            <input type="date" name="date" value="{{ request('date') }}" class="form-input-premium w-full text-sm">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg font-label-md flex-grow">Apply Filters</button>
            <a href="{{ route('admin.orders.index') }}" class="bg-surface-container-high px-4 py-2 rounded-lg text-sm border border-outline-variant">Reset</a>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-surface-container-low text-on-surface-variant font-label-sm uppercase tracking-widest text-[10px]">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Payment</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                @foreach($orders as $order)
                <tr class="hover:bg-surface-container-low/20 transition-colors">
                    <td class="px-6 py-4 font-bold text-sm">#ORD-{{ 1000 + $order->id }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-sm">{{ $order->customer_name ?? ($order->user->name ?? 'Guest') }}</p>
                        <p class="text-[10px] text-on-surface-variant">{{ $order->phone }}</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-primary">{{ number_format($order->total_amount) }} TZS</td>
                    <td class="px-6 py-4 text-xs font-medium uppercase tracking-widest">{{ $order->payment_method }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase 
                            @if($order->status == 'pending') bg-error-container text-on-error-container 
                            @elseif($order->status == 'delivered') bg-primary-container text-on-primary-container 
                            @else bg-surface-variant text-on-surface-variant @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 hover:bg-primary/10 rounded-lg text-primary transition-colors">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </a>
                            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="p-2 hover:bg-secondary/10 rounded-lg text-secondary transition-colors">
                                <span class="material-symbols-outlined text-xl">print</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-outline-variant/30">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection
