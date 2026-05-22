@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Customer Relationship (CRM)</h2>
        <p class="font-body-md text-on-surface-variant">Manage your beauty community, loyalty, and access controls.</p>
    </div>
</div>

<!-- CRM Filters & Segments -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-stack-lg">
    <div class="glass-card p-4 rounded-xl border border-outline-variant/30 flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase font-bold text-on-surface-variant">VIP Members</p>
            <h4 class="text-xl font-bold text-primary">{{ \App\Models\User::where('customer_segment', 'VIP')->count() }}</h4>
        </div>
        <span class="material-symbols-outlined text-primary">workspace_premium</span>
    </div>
    <div class="glass-card p-4 rounded-xl border border-outline-variant/30 flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase font-bold text-on-surface-variant">Regulars</p>
            <h4 class="text-xl font-bold">{{ \App\Models\User::where('customer_segment', 'regular')->count() }}</h4>
        </div>
        <span class="material-symbols-outlined text-secondary">group</span>
    </div>
    <div class="glass-card p-4 rounded-xl border border-outline-variant/30 flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase font-bold text-on-surface-variant">New Signups</p>
            <h4 class="text-xl font-bold">{{ \App\Models\User::where('customer_segment', 'new')->count() }}</h4>
        </div>
        <span class="material-symbols-outlined text-on-surface-variant">person_add</span>
    </div>
    <div class="glass-card p-4 rounded-xl border border-error/20 bg-error-container/5 flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase font-bold text-error">Banned</p>
            <h4 class="text-xl font-bold text-error">{{ \App\Models\User::where('is_banned', true)->count() }}</h4>
        </div>
        <span class="material-symbols-outlined text-error">block</span>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="glass-card p-6 rounded-xl border border-outline-variant/30 mb-stack-lg">
    <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-4">
        <div class="relative flex-grow">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
            <input type="text" name="search" value="{{ request('search') }}" class="form-input-premium w-full pl-10 text-sm" placeholder="Search by name or email...">
        </div>
        <select name="segment" class="form-input-premium text-sm">
            <option value="">All Segments</option>
            <option value="new" {{ request('segment') == 'new' ? 'selected' : '' }}>New</option>
            <option value="regular" {{ request('segment') == 'regular' ? 'selected' : '' }}>Regular</option>
            <option value="VIP" {{ request('segment') == 'VIP' ? 'selected' : '' }}>VIP</option>
        </select>
        <button type="submit" class="bg-primary text-white px-8 py-2 rounded-xl font-label-md">Filter</button>
    </form>
</div>

<!-- Customer List Table -->
<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-surface-container-low text-on-surface-variant font-label-sm uppercase tracking-widest text-[10px]">
                <tr>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Loyalty Points</th>
                    <th class="px-6 py-4">Total Spending</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                @foreach($customers as $customer)
                <tr class="hover:bg-surface-container-low/20 transition-colors {{ $customer->is_banned ? 'opacity-50 grayscale' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm">{{ $customer->name }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ $customer->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-1 font-bold text-primary">
                            <span class="material-symbols-outlined text-sm">stars</span>
                            {{ $customer->loyalty_points }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ number_format($customer->total_spent) }} TZS</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase 
                            {{ $customer->customer_segment == 'VIP' ? 'bg-primary text-white' : 'bg-surface-variant text-on-surface-variant' }}">
                            {{ $customer->customer_segment }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="p-2 hover:bg-primary/10 rounded-lg text-primary transition-colors" title="View Profile">
                                <span class="material-symbols-outlined text-xl">account_box</span>
                            </a>
                            <form action="{{ route('admin.customers.toggle-ban', $customer->id) }}" method="POST" onsubmit="return confirm('Change ban status for this customer?')">
                                @csrf
                                <button type="submit" class="p-2 hover:bg-error/10 rounded-lg text-error transition-colors" title="{{ $customer->is_banned ? 'Unban' : 'Ban' }}">
                                    <span class="material-symbols-outlined text-xl">{{ $customer->is_banned ? 'undo' : 'block' }}</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-outline-variant/30">
        {{ $customers->appends(request()->query())->links() }}
    </div>
</div>
@endsection
