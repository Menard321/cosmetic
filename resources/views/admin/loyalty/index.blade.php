@extends('layouts.admin')

@section('content')
<!-- Header -->
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Loyalty Intelligence</h2>
        <p class="font-body-md text-on-surface-variant flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-primary">verified</span>
            Enterprise Rewards & Customer Engagement Control
        </p>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('admin.loyalty.campaigns.create') }}" class="px-6 py-2.5 bg-on-background text-white rounded-xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            New Campaign
        </a>
        <a href="{{ route('admin.loyalty.events.create') }}" class="px-6 py-2.5 bg-primary-container text-on-primary-container rounded-xl font-label-md text-xs uppercase tracking-widest hover:brightness-95 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">event</span>
            Create Event
        </a>
    </div>
</div>

<!-- Intelligence KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-stack-lg">
    <div class="glass-card p-8 rounded-[2rem] border border-outline-variant/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <span class="material-symbols-outlined text-6xl text-primary">groups</span>
        </div>
        <p class="text-[10px] uppercase font-black text-on-surface-variant mb-6 tracking-[0.2em] opacity-60">Avg. Lifetime Value</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ number_format($avgCLV) }} TZS</h3>
        <div class="flex items-center gap-2 text-green-600 font-bold text-[10px] uppercase">
            <span class="material-symbols-outlined text-[14px]">trending_up</span>
            <span>Stable growth</span>
        </div>
    </div>

    <div class="glass-card p-8 rounded-[2rem] border border-outline-variant/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <span class="material-symbols-outlined text-6xl text-primary">redeem</span>
        </div>
        <p class="text-[10px] uppercase font-black text-on-surface-variant mb-6 tracking-[0.2em] opacity-60">Redemption Rate</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ number_format($redemptionRate, 1) }}%</h3>
        <div class="flex items-center gap-2 text-primary font-bold text-[10px] uppercase">
            <span class="material-symbols-outlined text-[14px]">token</span>
            <span>Healthy utilization</span>
        </div>
    </div>

    <div class="glass-card p-8 rounded-[2rem] border border-outline-variant/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <span class="material-symbols-outlined text-6xl text-primary">savings</span>
        </div>
        <p class="text-[10px] uppercase font-black text-on-surface-variant mb-6 tracking-[0.2em] opacity-60">Points in Circulation</p>
        <h3 class="font-headline-sm text-3xl mb-2">{{ number_format($totalEarned - $totalRedeemed) }}</h3>
        <p class="text-[10px] text-on-surface-variant font-medium mt-2">Active liabilities</p>
    </div>

    <div class="glass-card p-8 rounded-[2rem] border border-outline-variant/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <span class="material-symbols-outlined text-6xl text-primary">loyalty</span>
        </div>
        <p class="text-[10px] uppercase font-black text-on-surface-variant mb-6 tracking-[0.2em] opacity-60">Reward Efficiency</p>
        <h3 class="font-headline-sm text-3xl mb-2">High</h3>
        <div class="flex items-center gap-2 text-tertiary font-bold text-[10px] uppercase">
            <span>Optimization: Peak</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mb-stack-lg">
    <!-- Active Campaigns -->
    <div class="lg:col-span-2 glass-card p-10 rounded-[3rem] border border-outline-variant/30">
        <div class="flex justify-between items-center mb-10">
            <h4 class="text-xs uppercase font-black text-on-surface tracking-[0.2em]">Active Intelligence Campaigns</h4>
            <a href="{{ route('admin.loyalty.campaigns.index') }}" class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">Manage All</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($activeCampaigns as $campaign)
                <div class="p-6 bg-surface-container-low rounded-[2rem] border border-outline-variant/10 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl text-primary">auto_awesome</span>
                    </div>
                    <div class="relative z-10">
                        <span class="px-3 py-1 bg-primary text-white text-[8px] font-black uppercase tracking-widest rounded-full">{{ $campaign->multiplier }}x MULTIPLIER</span>
                        <h5 class="text-sm font-black mt-4 mb-1">{{ $campaign->name }}</h5>
                        <p class="text-[10px] text-on-surface-variant opacity-70 mb-4">{{ $campaign->category->name ?? 'Universal' }} Category</p>
                        <div class="flex justify-between items-end border-t border-outline-variant/10 pt-4 mt-4">
                            <div>
                                <p class="text-[9px] uppercase font-black text-on-surface-variant opacity-40 mb-1">Ends In</p>
                                <p class="text-[11px] font-bold">{{ $campaign->ends_at->diffForHumans() }}</p>
                            </div>
                            <span class="material-symbols-outlined text-primary text-[20px]">flash_on</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-20 opacity-30">
                    <span class="material-symbols-outlined text-5xl mb-4">campaign</span>
                    <p class="text-xs font-black uppercase tracking-widest">No active campaigns detected</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Branch Performance -->
    <div class="glass-card p-10 rounded-[3rem] border border-outline-variant/30 flex flex-col">
        <h4 class="text-xs uppercase font-black text-on-surface tracking-[0.2em] mb-10">Loyalty Engagement per Branch</h4>
        <div class="space-y-8 flex-grow">
            @foreach($branches as $branch)
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary-container/20 rounded-2xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">storefront</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-end mb-2">
                            <h5 class="text-[11px] font-black uppercase tracking-tight">{{ $branch->name }}</h5>
                            <span class="text-[10px] font-bold text-on-surface-variant">{{ $branch->orders_count }} Loyalists</span>
                        </div>
                        <div class="w-full h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width: {{ min(100, $branch->orders_count * 5) }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8 pt-8 border-t border-outline-variant/10">
            <p class="text-[10px] text-center text-on-surface-variant italic opacity-60">Data synchronized across network</p>
        </div>
    </div>
</div>

<!-- Bottom Intelligence Feed -->
<div class="grid grid-cols-1 gap-gutter">
    <div class="glass-card rounded-[3rem] border border-outline-variant/30 overflow-hidden shadow-sm">
        <div class="px-10 py-8 bg-surface-container-low border-b border-outline-variant/20 flex justify-between items-center">
            <h4 class="text-xs uppercase font-black text-on-surface tracking-[0.2em]">Tier Distribution Intelligence</h4>
            <div class="flex gap-3">
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-outline-variant/30 text-[9px] font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-[#C0C0C0]"></span> Silver
                </span>
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-outline-variant/30 text-[9px] font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-[#FFD700]"></span> Gold
                </span>
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-outline-variant/30 text-[9px] font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-[#E5E4E2]"></span> Platinum
                </span>
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-outline-variant/30 text-[9px] font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-[#B9F2FF]"></span> Diamond
                </span>
            </div>
        </div>
        <div class="p-10 bg-white">
            <div class="flex gap-4 h-12 rounded-[2rem] overflow-hidden bg-surface-container-low relative">
                @php
                    $tiers = \App\Models\LoyaltyTier::all();
                    $totalUsers = \App\Models\User::role('customer')->count();
                @endphp
                @foreach($tiers as $tier)
                    @php
                        $count = \App\Models\User::role('customer')->where('loyalty_level', $tier->name)->count();
                        $percent = $totalUsers > 0 ? ($count / $totalUsers) * 100 : 0;
                    @endphp
                    <div class="h-full relative group" style="width: {{ $percent }}%; background-color: {{ $tier->color_hex }}">
                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-4 bg-on-background text-white text-[10px] font-black py-2 px-4 rounded-xl opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap">
                            {{ $tier->name }}: {{ number_format($percent, 1) }}% ({{ $count }} users)
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-10">
                @foreach($tiers as $tier)
                    <div class="p-6 rounded-[2rem] border border-outline-variant/10 bg-surface-container-low/30">
                        <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant opacity-60 mb-3">{{ $tier->name }}</p>
                        <h6 class="text-xl font-black">{{ \App\Models\User::role('customer')->where('loyalty_level', $tier->name)->count() }} <span class="text-xs opacity-40 font-medium">Members</span></h6>
                        <p class="text-[9px] font-bold text-primary mt-2">Unlock: {{ $tier->discount_percentage }}% Disc.</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
