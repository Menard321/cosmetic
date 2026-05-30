@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Campaign Manager</h2>
        <p class="font-body-md text-on-surface-variant">Create and manage point multiplier campaigns across product categories.</p>
    </div>
    <a href="{{ route('admin.loyalty.campaigns.create') }}" class="px-6 py-2.5 bg-on-background text-white rounded-xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]">add_circle</span>
        New Campaign
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
    @forelse($campaigns as $campaign)
        <div class="glass-card p-8 rounded-[2.5rem] border border-outline-variant/30 relative overflow-hidden group hover:shadow-xl transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-6xl text-primary">auto_awesome</span>
            </div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-4 py-1.5 bg-primary text-white text-[9px] font-black uppercase tracking-widest rounded-full">{{ $campaign->multiplier }}x</span>
                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $campaign->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $campaign->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <h4 class="text-lg font-black uppercase tracking-tight mb-2">{{ $campaign->name }}</h4>
                <p class="text-xs text-on-surface-variant mb-6">{{ $campaign->category->name ?? 'Universal' }} Category</p>
                
                <div class="border-t border-outline-variant/20 pt-6 mt-6 flex justify-between items-end">
                    <div>
                        <p class="text-[9px] uppercase font-black text-on-surface-variant opacity-40 mb-1">Duration</p>
                        <p class="text-[11px] font-bold">{{ $campaign->starts_at->format('M d') }} — {{ $campaign->ends_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.loyalty.campaigns.edit', $campaign) }}" class="w-8 h-8 rounded-xl bg-surface-container-high flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                        </a>
                        <form action="{{ route('admin.loyalty.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Terminate this campaign?')">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 rounded-xl bg-surface-container-high flex items-center justify-center hover:bg-error hover:text-white transition-all">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 p-20 glass-card rounded-[3rem] border border-dashed border-outline-variant/30 text-center">
            <span class="material-symbols-outlined text-5xl text-outline mb-6">campaign</span>
            <p class="text-xs font-black uppercase tracking-[0.3em] text-outline">No campaigns created yet</p>
        </div>
    @endforelse
</div>
@endsection
