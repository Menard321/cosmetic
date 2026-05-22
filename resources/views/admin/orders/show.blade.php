@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.orders.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Orders
    </a>
    <div class="flex justify-between items-end">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Order #ORD-{{ 1000 + $order->id }}</h2>
            <p class="font-body-md text-on-surface-variant">Placed on {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="border border-outline-variant px-6 py-3 rounded-xl font-label-md flex items-center gap-2 hover:bg-surface-container transition-all">
                <span class="material-symbols-outlined">print</span> Print Invoice
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
    <!-- Order Items -->
    <div class="lg:col-span-2 space-y-gutter">
        <div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30">
                <h4 class="font-label-md text-on-surface uppercase font-bold">Order Items</h4>
            </div>
            <div class="p-6">
                <table class="w-full text-left">
                    <thead class="text-on-surface-variant text-[10px] uppercase font-bold border-b border-outline-variant/20">
                        <tr>
                            <th class="pb-4">Product</th>
                            <th class="pb-4 text-center">Quantity</th>
                            <th class="pb-4 text-right">Price</th>
                            <th class="pb-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $item->product->image_url }}" class="w-12 h-12 rounded object-cover">
                                    <div>
                                        <p class="font-bold text-sm">{{ $item->product->name }}</p>
                                        <p class="text-[10px] text-on-surface-variant Uppercase">{{ $item->product->brand }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center font-medium">{{ $item->quantity }}</td>
                            <td class="py-4 text-right text-sm">{{ number_format($item->price) }}</td>
                            <td class="py-4 text-right font-bold">{{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-outline-variant/30">
                            <td colspan="3" class="pt-6 pb-2 text-right text-sm text-on-surface-variant uppercase font-bold">Subtotal</td>
                            <td class="pt-6 pb-2 text-right font-bold">{{ number_format($order->total_amount) }} TZS</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-2 text-right text-sm text-on-surface-variant uppercase font-bold">Shipping</td>
                            <td class="py-2 text-right font-bold">0 TZS</td>
                        </tr>
                        <tr class="text-primary">
                            <td colspan="3" class="pt-4 text-right font-display-sm text-headline-sm uppercase font-bold">Grand Total</td>
                            <td class="pt-4 text-right font-display-sm text-headline-sm font-bold">{{ number_format($order->total_amount) }} TZS</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-gutter">
        <!-- Status Management -->
        <div class="glass-card p-6 rounded-xl border border-primary/20 bg-primary-container/5 shadow-sm">
            <h4 class="font-label-md text-on-surface uppercase font-bold mb-4">Manage Fulfillment</h4>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <select name="status" class="form-input-premium w-full text-sm">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
                <button type="submit" class="w-full bg-on-background text-white py-3 rounded-lg font-bold hover:bg-primary transition-all">Update Status</button>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="glass-card p-6 rounded-xl border border-outline-variant/30 shadow-sm">
            <h4 class="font-label-md text-on-surface uppercase font-bold mb-4">Customer Details</h4>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">person</span>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-on-surface-variant">Name</p>
                        <p class="font-bold text-sm">{{ $order->customer_name ?? ($order->user->name ?? 'Guest User') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">mail</span>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-on-surface-variant">Email</p>
                        <p class="text-sm">{{ $order->user->email ?? 'no-email@guest.com' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">phone</span>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-on-surface-variant">Phone</p>
                        <p class="font-bold text-sm">{{ $order->phone }}</p>
                    </div>
                </div>
                <div class="pt-4 border-t border-outline-variant/30">
                    <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-1">Delivery Address</p>
                    <p class="text-sm leading-relaxed">{{ $order->delivery_address }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="glass-card p-6 rounded-xl border border-outline-variant/30 shadow-sm">
            <h4 class="font-label-md text-on-surface uppercase font-bold mb-4">Payment Method</h4>
            <div class="p-4 bg-surface-container-low rounded-lg flex items-center justify-between border border-outline-variant/20">
                <span class="font-bold text-primary">{{ strtoupper($order->payment_method) }}</span>
                <span class="material-symbols-outlined text-primary">verified_user</span>
            </div>
        </div>
    </div>
</div>
@endsection
