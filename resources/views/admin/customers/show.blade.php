@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.customers.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Community
    </a>
    <div class="flex justify-between items-center">
        <h2 class="font-headline-md text-headline-md text-on-surface">Customer Profile</h2>
        <div class="flex gap-4">
            <span class="px-4 py-2 bg-primary/10 text-primary border border-primary/20 rounded-xl font-bold uppercase text-xs">
                {{ $user->customer_segment }} Member
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
    <!-- Bio & Stats -->
    <div class="space-y-gutter">
        <div class="glass-card p-8 rounded-xl border border-outline-variant/30 text-center">
            <div class="w-24 h-24 rounded-full bg-primary/10 text-primary flex items-center justify-center text-4xl font-bold mx-auto mb-6 border-4 border-white shadow-xl">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h3 class="font-headline-sm text-headline-sm text-on-surface mb-1">{{ $user->name }}</h3>
            <p class="text-on-surface-variant text-sm mb-6">{{ $user->email }}</p>
            
            <div class="grid grid-cols-2 gap-4 border-t border-outline-variant/30 pt-6">
                <div>
                    <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-1">Total Spent</p>
                    <p class="font-bold text-primary">{{ number_format($user->total_spent) }} TZS</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-1">Orders</p>
                    <p class="font-bold">{{ $user->order_count }}</p>
                </div>
            </div>
        </div>

        <!-- Loyalty Management -->
        <div class="glass-card p-6 rounded-xl border border-primary/20 bg-primary-container/5">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary">stars</span>
                <h4 class="font-label-md text-on-surface uppercase font-bold">Loyalty Wallet</h4>
            </div>
            <form action="{{ route('admin.customers.points', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] uppercase font-bold text-on-surface-variant block mb-1">Balance Points</label>
                    <input type="number" name="points" value="{{ $user->loyalty_points }}" class="form-input-premium w-full text-center text-xl font-bold">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-secondary transition-colors">Update Loyalty Points</button>
            </form>
        </div>
    </div>

    <!-- Order History -->
    <div class="lg:col-span-2 space-y-gutter">
        <div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
                <h4 class="font-label-md text-on-surface uppercase font-bold">Recent Beauty Purchases</h4>
                <a href="{{ route('admin.orders.index', ['customer' => $user->name]) }}" class="text-primary text-xs font-bold hover:underline">View All Orders</a>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low text-on-surface-variant font-label-sm uppercase tracking-widest text-[10px]">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @foreach($user->orders as $order)
                        <tr class="hover:bg-surface-container-low/20 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold">#ORD-{{ 1000 + $order->id }}</td>
                            <td class="px-6 py-4 text-xs text-on-surface-variant">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 font-medium">{{ number_format($order->total_amount) }} TZS</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-surface-variant">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Fraud Control -->
        <div class="glass-card p-6 rounded-xl border border-error/20 bg-error-container/5">
            <h4 class="font-label-md text-error uppercase font-bold mb-4">Security & Access Control</h4>
            <div class="flex items-center justify-between">
                <div>
                    <h5 class="font-bold text-on-surface">Blacklist Account</h5>
                    <p class="text-xs text-on-surface-variant">Banned customers cannot login or place new orders.</p>
                </div>
                <form action="{{ route('admin.customers.toggle-ban', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 rounded-lg font-bold transition-all {{ $user->is_banned ? 'bg-secondary text-white' : 'bg-error text-white hover:opacity-90' }}">
                        {{ $user->is_banned ? 'Restore Access' : 'Ban Customer' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
