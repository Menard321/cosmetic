@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Beauty Events</h2>
        <p class="font-body-md text-on-surface-variant">Manage workshops, masterclasses, and exclusive beauty experiences.</p>
    </div>
    <a href="{{ route('admin.loyalty.events.create') }}" class="px-6 py-2.5 bg-on-background text-white rounded-xl font-label-md text-xs uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]">add_circle</span>
        Create Event
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">{{ session('success') }}</div>
@endif

<div class="glass-card rounded-[3rem] border border-outline-variant/30 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-surface-container-low text-[9px] font-black uppercase tracking-[0.2em] text-on-surface-variant border-b border-outline-variant/20">
                <tr>
                    <th class="px-8 py-5">Event</th>
                    <th class="px-8 py-5">Date</th>
                    <th class="px-8 py-5">Location</th>
                    <th class="px-8 py-5">Tickets</th>
                    <th class="px-8 py-5">Status</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($events as $event)
                    <tr class="hover:bg-surface-container-low/50 transition-colors text-sm">
                        <td class="px-8 py-5">
                            <h4 class="font-bold text-on-surface">{{ $event->title }}</h4>
                            <p class="text-[10px] text-on-surface-variant opacity-60 mt-0.5">{{ Str::limit($event->description, 50) }}</p>
                        </td>
                        <td class="px-8 py-5 text-on-surface-variant font-medium">{{ $event->event_date->format('M d, Y H:i') }}</td>
                        <td class="px-8 py-5 text-on-surface-variant">{{ $event->location }}</td>
                        <td class="px-8 py-5">
                            <span class="font-black text-primary">{{ $event->tickets_count }}</span>
                            <span class="text-on-surface-variant opacity-50"> / {{ $event->capacity }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $event->is_active ? 'bg-green-100 text-green-700' : 'bg-surface-variant text-on-surface-variant' }}">
                                {{ $event->is_active ? 'Active' : 'Closed' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.loyalty.events.show', $event) }}" class="w-8 h-8 rounded-xl bg-surface-container-high flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.loyalty.events.edit', $event) }}" class="w-8 h-8 rounded-xl bg-surface-container-high flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                </a>
                                <form action="{{ route('admin.loyalty.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                    @csrf @method('DELETE')
                                    <button class="w-8 h-8 rounded-xl bg-surface-container-high flex items-center justify-center hover:bg-error hover:text-white transition-all">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-on-surface-variant italic">No events scheduled yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
