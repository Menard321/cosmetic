@extends('layouts.admin')

@section('content')
<!-- Header -->
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Executive Overview</h2>
        <p class="font-body-md text-on-surface-variant">
            {{ $selectedBranch ? 'Performance for ' . $selectedBranch->name : 'Global Monitoring for Niffer Cosmetic branches.' }}
        </p>
    </div>
    <div class="flex gap-4">
        <form action="{{ route('admin.page') }}" method="GET" class="flex gap-2">
            <select name="branch_id" onchange="this.form.submit()" class="bg-white border border-outline-variant px-6 py-2 rounded-xl font-label-md text-sm cursor-pointer hover:border-primary transition-colors focus:ring-2 focus:ring-primary/20 outline-none">
                <option value="">Global View (All Branches)</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </form>
        <div class="flex items-center gap-2 px-4 py-2 bg-primary-container/10 border border-primary-container/20 rounded-xl text-primary font-bold">
            <span class="material-symbols-outlined text-[20px]">hub</span>
            <span>{{ $selectedBranch ? 'Single Branch Mode' : 'Network Mode' }}</span>
        </div>
    </div>
</div>

<!-- KPI Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-stack-lg">
    <!-- Revenue -->
    <div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
        <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-4 tracking-widest leading-none">Global Revenue</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ number_format($totalRevenue) }} TZS</h3>
        <div class="flex items-center gap-2 text-primary font-bold text-xs">
            <span class="material-symbols-outlined text-[14px]">trending_up</span>
            <span>Global growth this month</span>
        </div>
    </div>
    <!-- Orders -->
    <div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
        <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-4 tracking-widest leading-none">Total Orders</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ number_format($totalOrders) }}</h3>
        <div class="flex items-center gap-2 text-secondary font-bold text-xs">
            <span class="material-symbols-outlined text-[14px]">shopping_bag</span>
            <span>Fulfilled across {{ $branches->count() }} locations</span>
        </div>
    </div>
    <!-- Branches -->
    <div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
        <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-4 tracking-widest leading-none">Active Branches</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ $branches->count() }}</h3>
        <div class="flex items-center gap-2 text-tertiary font-bold text-xs uppercase tracking-tighter">
            <span>Sinza • Kigamboni • Dodoma</span>
        </div>
    </div>
    <!-- Members -->
    <div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
        <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-4 tracking-widest leading-none">Global Members</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ number_format($totalCustomers) }}</h3>
        <div class="flex items-center gap-2 text-pink-600 font-bold text-xs uppercase tracking-tighter">
            <span class="material-symbols-outlined text-[14px]">auto_awesome</span>
            <span>Premium Beauty Community</span>
        </div>
    </div>
</div>

<!-- Middle Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mb-stack-lg">
    <div class="lg:col-span-2 glass-card p-8 rounded-xl border border-outline-variant/30">
        <div class="flex justify-between items-center mb-8 border-b border-outline-variant/20 pb-4">
            <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em]">New Member Activity</h4>
            <a href="{{ route('admin.customers.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">View CRM</a>
        </div>
        <div class="space-y-4">
            @forelse($recentCustomers as $customer)
                <div class="flex justify-between items-center p-4 bg-surface-container-low/50 rounded-2xl hover:bg-white transition-all border border-transparent hover:border-outline-variant/20">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary-container text-primary flex items-center justify-center font-bold text-sm">
                            {{ substr($customer->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold">{{ $customer->name }}</p>
                            <p class="text-[10px] text-on-surface-variant">{{ $customer->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">{{ $customer->created_at->diffForHumans() }}</p>
                        <p class="text-[9px] text-primary/60 font-black uppercase tracking-widest">New Member</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <span class="material-symbols-outlined text-4xl text-outline-variant mb-4">person_add</span>
                    <p class="text-on-surface-variant italic">No new members registered today.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="glass-card p-8 rounded-xl border border-outline-variant/30 flex flex-col">
        <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em] mb-8">Quick Revenue Overview</h4>
        <div class="space-y-6 flex-grow overflow-y-auto">
            @foreach($branchRevenue as $name => $revenue)
                <div class="relative pt-1">
                    <div class="flex mb-2 items-center justify-between">
                        <div>
                            <span class="text-xs font-bold inline-block py-1 px-2 uppercase rounded-full text-primary bg-primary-container/20">
                                {{ explode(' ', $name)[2] ?? $name }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-black inline-block text-primary">
                                {{ number_format($revenue) }} TZS
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-1.5 mb-4 text-xs flex rounded bg-primary-container/10">
                        <div style="width:{{ $totalRevenue > 0 ? ($revenue / $totalRevenue) * 100 : 0 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary transition-all duration-1000"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Bottom Section -->
<div class="grid grid-cols-1 gap-gutter">
    <div class="glass-card rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-low">
            <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em]">Branch Performance Leaderboard</h4>
            <div class="flex gap-2">
                @foreach($branches as $branch)
                    <div class="flex items-center gap-2 px-3 py-1 bg-white border border-outline-variant rounded-full text-[10px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full {{ $branch->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $branch->name }}
                    </div>
                @endforeach
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-lowest text-on-surface-variant">
                    <tr>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Branch Name</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold">Location</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-center">Orders</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-right">Revenue (TZS)</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @foreach($branches as $branch)
                        <tr class="hover:bg-primary-container/5 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-on-surface">{{ $branch->name }}</span>
                                    <span class="text-[10px] text-on-surface-variant">{{ $branch->phone }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-sm">{{ $branch->location }}</td>
                            <td class="px-8 py-6 text-sm text-center font-bold">{{ $branch->orders_count }}</td>
                            <td class="px-8 py-6 text-sm text-right font-bold tabular-nums">
                                {{ number_format($branchRevenue[$branch->name] ?? 0) }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] rounded-full uppercase font-bold">Active</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection