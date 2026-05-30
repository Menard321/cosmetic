@extends('layouts.admin')

@section('content')
<div class="space-y-gutter animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Business Intelligence</h2>
            <p class="font-body-md text-on-surface-variant text-label-md uppercase tracking-widest italic">Performance & Growth Analytics</p>
        </div>
        <button class="bg-primary text-white px-6 py-2.5 rounded-xl font-label-md flex items-center gap-2 hover:shadow-lg transition-all">
            <span class="material-symbols-outlined text-[20px]">download</span>
            Export Annual Report
        </button>
    </div>

    <!-- Analytics Primary Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <!-- Revenue Chart Visualization -->
        <div class="lg:col-span-2 glass-card p-stack-lg rounded-full border border-outline-variant/30 flex flex-col h-[400px]">
            <div class="flex justify-between items-center mb-10">
                <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em]">Revenue Trend (2026)</h4>
                <div class="flex gap-4">
                    <span class="flex items-center gap-2 text-[10px] font-bold text-primary italic">
                        <span class="w-2 h-2 rounded-full bg-primary"></span> Online Sales
                    </span>
                    <span class="flex items-center gap-2 text-[10px] font-bold text-outline uppercase">
                        <span class="w-2 h-2 rounded-full bg-outline"></span> Branch POS
                    </span>
                </div>
            </div>
            
            <div class="flex-grow flex items-end gap-stack-lg px-4">
                @foreach($monthlyRevenue as $month => $revenue)
                <div class="flex-1 flex flex-col items-center group relative">
                    <div class="w-full bg-primary/10 rounded-t-xl transition-all duration-500 hover:bg-primary/40 group-hover:bg-primary" style="height: {{ max(10, $revenue / 10000) }}%">
                        <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-on-background text-white text-[10px] py-1.5 px-3 rounded-full opacity-0 group-hover:opacity-100 transition-all pointer-events-none shadow-xl">
                            {{ number_format($revenue) }} TZS
                        </div>
                    </div>
                    <p class="mt-4 text-[10px] font-bold text-on-surface-variant uppercase">{{ $month }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Conversion & Growth -->
        <div class="space-y-gutter flex flex-col">
            <div class="glass-card p-8 rounded-full border border-outline-variant/30 flex-grow bg-primary-container/5 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl group-hover:bg-primary/20 transition-all"></div>
                <h4 class="text-xs uppercase font-bold text-primary tracking-[0.2em] mb-4">Customer Growth</h4>
                <div class="flex items-baseline gap-2 mb-2">
                    <h3 class="text-4xl font-headline-sm">+24.8%</h3>
                    <span class="text-green-600 text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">arrow_upward</span> this month
                    </span>
                </div>
                <p class="text-xs text-on-surface-variant mb-6">Active community members expanding across all branches.</p>
                <div class="w-full h-1 bg-surface-container rounded-full overflow-hidden">
                    <div class="w-[74%] h-full bg-primary animate-pulse"></div>
                </div>
                <p class="text-[10px] mt-2 text-on-surface-variant italic leading-none">Target: 5,000 members by December</p>
            </div>

            <div class="glass-card p-8 rounded-full border border-outline-variant/30 flex-grow bg-secondary-container/5">
                <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em] mb-4">Branch Distribution</h4>
                <div class="space-y-4">
                    @foreach($branches as $branch)
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase text-on-surface-variant">{{ $branch->name }}</span>
                        <div class="flex-1 mx-4 h-1 bg-surface-container rounded-full overflow-hidden">
                            <div class="h-full bg-outline" style="width: {{ rand(30, 90) }}%"></div>
                        </div>
                        <span class="text-[10px] font-bold text-on-surface">{{ $branch->orders_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Product Analytics & Leaderboard -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
        <div class="glass-card rounded-full border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex justify-between items-center">
                <h4 class="text-xs uppercase font-bold text-on-surface tracking-[0.2em]">Top Performing Products</h4>
                <span class="text-[10px] text-primary font-bold italic tracking-tighter">Real-time velocity tracking</span>
            </div>
            <div class="divide-y divide-outline-variant/20">
                @foreach($topProducts as $index => $product)
                <div class="p-6 flex items-center gap-6 hover:bg-primary-container/5 transition-all">
                    <span class="text-xl font-headline-sm text-outline/30 italic">0{{ $index + 1 }}</span>
                    <div class="w-14 h-14 rounded-xl bg-surface-variant overflow-hidden flex-shrink-0 shadow-inner">
                        <img class="w-full h-full object-cover" src="{{ $alert->image_url ?? $product->image_url }}"/>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-on-surface leading-tight">{{ $product->name }}</p>
                        <p class="text-[10px] text-on-surface-variant uppercase tracking-widest">{{ $product->brand }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-primary">{{ number_format($product->orders_sum_total_amount ?? 0) }} TZS</p>
                        <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-tighter">{{ $product->orders_count }} Units</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Regional Performance Cards -->
        <div class="grid grid-cols-2 gap-8">
            @foreach($branches as $branch)
            <div class="glass-card p-8 rounded-full border border-outline-variant/30 relative group hover:border-primary transition-all">
                <div class="mb-6 flex justify-between items-start">
                    <span class="material-symbols-outlined text-primary text-3xl group-hover:scale-110 transition-transform">location_on</span>
                    <span class="text-[8px] bg-primary-container/20 text-primary-fixed-variant px-2 py-0.5 rounded font-bold uppercase tracking-widest">{{ $branch->slug }}</span>
                </div>
                <h5 class="font-headline-sm text-xl mb-1">{{ $branch->name }}</h5>
                <p class="text-[10px] text-on-surface-variant mb-6 italic leading-none">{{ $branch->location }}</p>
                
                <div class="flex justify-between border-t border-outline-variant/30 pt-4">
                    <div>
                        <p class="text-[8px] uppercase font-bold text-on-surface-variant mb-1">Revenue</p>
                        <p class="text-xs font-bold text-on-surface">Consistent</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[8px] uppercase font-bold text-on-surface-variant mb-1">Growth</p>
                        <p class="text-xs font-bold text-green-600">+12%</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }
</style>
@endsection
