@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.loyalty.tiers.index') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline flex items-center gap-1 mb-4">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span> Back to Tiers
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Add Status Tier</h2>
    <p class="font-body-md text-on-surface-variant">Define a new membership level and its exclusive benefits.</p>
</div>

<div class="glass-card p-10 rounded-[3rem] border border-outline-variant/30 max-w-2xl">
    <form action="{{ route('admin.loyalty.tiers.store') }}" method="POST" class="space-y-8">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Tier Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="e.g. Gold">
                @error('name') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Brand Color (HEX)</label>
                <div class="flex gap-2">
                    <input type="color" class="w-14 h-14 bg-transparent border-none p-0 cursor-pointer" id="color-picker" value="{{ old('color_hex', '#d4af37') }}" oninput="document.getElementById('color-hex').value = this.value">
                    <input type="text" name="color_hex" id="color-hex" value="{{ old('color_hex', '#d4af37') }}" required class="flex-1 bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-mono uppercase">
                </div>
                @error('color_hex') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Points Threshold</label>
                <input type="number" name="min_points" value="{{ old('min_points') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="5000">
                @error('min_points') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Discount %</label>
                <input type="number" name="discount_percentage" step="0.1" value="{{ old('discount_percentage') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="10">
                @error('discount_percentage') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Perks (One per line)</label>
            <textarea name="perks_input" rows="5" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all resize-none" placeholder="Free home delivery&#10;Birthday surprise gift&#10;VIP workshop access">{{ old('perks_input') }}</textarea>
            <p class="text-[9px] text-on-surface-variant mt-2 italic px-2">These benefits will be displayed on the customer's wallet.</p>
        </div>

        <div class="pt-6 border-t border-outline-variant/20">
            <button type="submit" class="px-10 py-4 bg-on-background text-white rounded-2xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all shadow-lg shadow-primary/10">
                Create Status Tier
            </button>
        </div>
    </form>
</div>
@endsection
