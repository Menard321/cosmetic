@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Loyalty Tiers</h2>
        <p class="font-body-md text-on-surface-variant">Configure membership levels, point thresholds, and exclusive perks.</p>
    </div>
    <a href="{{ route('admin.loyalty.tiers.create') }}" class="px-6 py-2.5 bg-on-background text-white rounded-xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]">add_circle</span>
        Add Tier
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
    @foreach($tiers as $tier)
        <div class="glass-card p-10 rounded-[3rem] border border-outline-variant/30 flex flex-col relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 opacity-10 -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform" style="background-color: {{ $tier->color_hex }}; filter: blur(40px); border-radius: 100%;"></div>
            
            <div class="relative z-10 mb-8">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-outline-variant/20" style="background-color: {{ $tier->color_hex }}20; color: {{ $tier->color_hex }}">
                    <span class="material-symbols-outlined text-[24px]">workspace_premium</span>
                </div>
                <h4 class="text-xl font-black uppercase tracking-tighter">{{ $tier->name }}</h4>
                <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant opacity-60 mt-1">Status Level</p>
            </div>

            <div class="space-y-6 flex-grow">
                <div>
                    <p class="text-[9px] uppercase font-black text-on-surface-variant opacity-40 mb-2">Requirement</p>
                    <p class="text-lg font-bold tabular-nums">{{ number_format($tier->min_points) }} <span class="text-xs font-medium opacity-60">PTS</span></p>
                </div>
                <div>
                    <p class="text-[9px] uppercase font-black text-on-surface-variant opacity-40 mb-2">Benefit</p>
                    <p class="text-lg font-bold">{{ $tier->discount_percentage }}% <span class="text-xs font-medium opacity-60">OFF Orders</span></p>
                </div>
                <div>
                    <p class="text-[9px] uppercase font-black text-on-surface-variant opacity-40 mb-3">Key Perks</p>
                    <ul class="space-y-2">
                        @foreach($tier->perks ?? [] as $perk)
                            <li class="flex items-center gap-2 text-[10px] font-medium text-on-surface-variant">
                                <span class="w-1 h-1 rounded-full bg-primary"></span>
                                {{ $perk }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-outline-variant/10 flex gap-4">
                <a href="{{ route('admin.loyalty.tiers.edit', $tier) }}" class="flex-1 py-3 bg-surface-container-high rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-on-background hover:text-white transition-all">Edit</a>
                <form action="{{ route('admin.loyalty.tiers.destroy', $tier) }}" method="POST" onsubmit="return confirm('Delete this tier?')">
                    @csrf @method('DELETE')
                    <button class="w-12 py-3 bg-surface-container-high text-error rounded-2xl flex items-center justify-center hover:bg-error hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
