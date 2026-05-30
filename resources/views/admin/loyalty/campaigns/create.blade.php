@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.loyalty.campaigns.index') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline flex items-center gap-1 mb-4">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span> Back to Campaigns
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Launch Campaign</h2>
    <p class="font-body-md text-on-surface-variant">Create a point multiplier campaign to accelerate customer engagement.</p>
</div>

<div class="glass-card p-10 rounded-[3rem] border border-outline-variant/30 max-w-2xl">
    <form action="{{ route('admin.loyalty.campaigns.store') }}" method="POST" class="space-y-8">
        @csrf

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Campaign Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="e.g. Skincare Radiance Month">
            @error('name') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Category</label>
                <select name="category_id" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Point Multiplier</label>
                <input type="number" name="multiplier" step="0.5" min="1" max="10" value="{{ old('multiplier', 2) }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="2.0">
                @error('multiplier') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Start Date</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                @error('starts_at') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">End Date</label>
                <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                @error('ends_at') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-6 border-t border-outline-variant/20">
            <button type="submit" class="px-10 py-4 bg-on-background text-white rounded-2xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all shadow-lg shadow-primary/10">
                Launch Campaign
            </button>
        </div>
    </form>
</div>
@endsection
