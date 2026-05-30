@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.loyalty.events.index') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline flex items-center gap-1 mb-4">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span> Back to Events
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Edit Event</h2>
</div>

<div class="glass-card p-10 rounded-[3rem] border border-outline-variant/30 max-w-2xl">
    <form action="{{ route('admin.loyalty.events.update', $event) }}" method="POST" class="space-y-8">
        @csrf @method('PUT')

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Event Title</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Description</label>
            <textarea name="description" rows="4" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all resize-none">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Event Date & Time</label>
                <input type="datetime-local" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Location</label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-3">Max Attendees</label>
            <input type="number" name="max_attendees" min="1" value="{{ old('max_attendees', $event->capacity) }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all">
        </div>

        <div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ $event->is_active ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-outline-variant text-primary focus:ring-primary/20">
                <span class="text-sm font-bold">Event Active</span>
            </label>
        </div>

        <div class="pt-6 border-t border-outline-variant/20">
            <button type="submit" class="px-10 py-4 bg-on-background text-white rounded-2xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all shadow-lg shadow-primary/10">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
