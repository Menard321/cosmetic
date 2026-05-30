@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.loyalty.events.index') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline flex items-center gap-1 mb-4">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span> Back to Events
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Create Beauty Event</h2>
</div>

<div class="glass-card p-10 rounded-[3rem] border border-outline-variant/30 max-w-2xl">
    <form action="{{ route('admin.loyalty.events.store') }}" method="POST" class="space-y-8">
        @csrf

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Event Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="e.g. Glow Up Masterclass">
            @error('title') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Description</label>
            <textarea name="description" rows="4" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all resize-none" placeholder="Describe the experience...">{{ old('description') }}</textarea>
            @error('description') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Event Date & Time</label>
                <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                @error('event_date') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. Niffer Sinza Branch">
                @error('location') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Branch (Optional)</label>
                <select name="branch_id" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Max Attendees</label>
                <input type="number" name="max_attendees" min="1" value="{{ old('max_attendees', 50) }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                @error('max_attendees') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Points Cost (0 = Free)</label>
            <input type="number" name="points_required" min="0" value="{{ old('points_required', 0) }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
            @error('points_required') <p class="text-error text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="pt-6 border-t border-outline-variant/20">
            <button type="submit" class="px-10 py-4 bg-on-background text-white rounded-2xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all shadow-lg shadow-primary/10">
                Publish Event
            </button>
        </div>
    </form>
</div>
@endsection
