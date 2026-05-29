@extends('layouts.admin')

@section('content')
<!-- Header -->
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Executive Overview</h2>
        <p class="font-body-md text-on-surface-variant">
            {{ $selectedBranch ? 'Performance for ' . $selectedBranch->name : 'Global Monitoring for Angels Beauty branches.' }}
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
    <!-- Products -->
    <div class="glass-card p-6 rounded-xl shadow-sm border border-outline-variant/30">
        <p class="text-[10px] uppercase font-bold text-on-surface-variant mb-4 tracking-widest leading-none">Catalog Size</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ $totalProducts }}</h3>
        <div class="flex items-center gap-2 text-outline font-bold text-xs">
            <span class="material-symbols-outlined text-[14px]">inventory_2</span>
            <span>Universal Product IDs</span>
        </div>
    </div>
</div>

<!-- Middle Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mb-stack-lg">
    <div class="lg:col-span-2 glass-card p-8 rounded-xl border border-outline-variant/30">
        <div class="flex justify-between items-center mb-8">
            <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em]">Revenue Analysis per Branch</h4>
        </div>
        <div class="h-64 flex items-end gap-12 px-8">
            @foreach($branchRevenue as $name => $revenue)
                <div class="flex-1 flex flex-col items-center group relative">
                    <div class="w-full bg-primary/20 rounded-t-2xl transition-all hover:bg-primary group-hover:shadow-[0_0_30px_rgba(var(--primary-rgb),0.3)]" 
                         style="height: {{ $totalRevenue > 0 ? ($revenue / $totalRevenue) * 100 : 0 }}%">
                         <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-on-background text-white text-[10px] py-1 px-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            {{ number_format($revenue) }} TZS
                         </div>
                    </div>
                    <p class="mt-4 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">{{ explode(' ', $name)[2] ?? $name }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="glass-card p-8 rounded-xl border border-outline-variant/30 flex flex-col">
        <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em] mb-8">Global Stock Alerts</h4>
        <div class="space-y-6 flex-grow overflow-y-auto">
            @forelse($urgentAlerts as $alert)
                <div class="flex gap-4 p-4 bg-error-container/5 border border-error/10 rounded-2xl">
                    <div class="w-12 h-12 rounded-xl bg-surface-variant overflow-hidden flex-shrink-0">
                        <img class="w-full h-full object-cover" src="{{ $alert->image_url }}"/>
                    </div>
                    <div>
                        <p class="text-sm font-bold">{{ $alert->name }}</p>
                        <p class="text-[10px] text-error uppercase font-bold tracking-tighter">Critical Low Stock</p>
                        <div class="flex gap-1 mt-2">
                            @foreach($alert->branches->where('pivot.stock_quantity', '<', 10) as $branch)
                                <span class="bg-error/10 text-error text-[8px] px-1.5 py-0.5 rounded">{{ $branch->slug }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-4xl text-outline mb-2">check_circle</span>
                    <p class="text-on-surface-variant italic">All branches well stocked.</p>
                </div>
            @endforelse
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