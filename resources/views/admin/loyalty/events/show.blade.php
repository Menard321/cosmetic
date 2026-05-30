@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.loyalty.events.index') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline flex items-center gap-1 mb-4">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span> Back to Events
    </a>
    <div class="flex justify-between items-end">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">{{ $event->title }}</h2>
            <p class="font-body-md text-on-surface-variant">{{ $event->event_date->format('l, F d, Y \a\t H:i') }} — {{ $event->location }}</p>
        </div>
        <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest {{ $event->is_active ? 'bg-green-100 text-green-700' : 'bg-surface-variant text-on-surface-variant' }}">
            {{ $event->is_active ? 'Active' : 'Closed' }}
        </span>
    </div>
</div>

<!-- Event Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-stack-lg">
    <div class="glass-card p-8 rounded-[2rem] border border-outline-variant/30">
        <p class="text-[10px] uppercase font-black text-on-surface-variant mb-4 tracking-[0.2em] opacity-60">Total Tickets</p>
        <h3 class="font-headline-sm text-3xl">{{ $event->tickets->count() }} <span class="text-sm opacity-40 font-medium">/ {{ $event->capacity }}</span></h3>
    </div>
    <div class="glass-card p-8 rounded-[2rem] border border-outline-variant/30">
        <p class="text-[10px] uppercase font-black text-on-surface-variant mb-4 tracking-[0.2em] opacity-60">Checked In</p>
        <h3 class="font-headline-sm text-3xl text-green-600">{{ $event->tickets->where('status', 'checked_in')->count() }}</h3>
    </div>
    <div class="glass-card p-8 rounded-[2rem] border border-outline-variant/30">
        <p class="text-[10px] uppercase font-black text-on-surface-variant mb-4 tracking-[0.2em] opacity-60">Points Cost</p>
        <h3 class="font-headline-sm text-3xl text-primary">{{ $event->points_required > 0 ? number_format($event->points_required) . ' PTS' : 'Free' }}</h3>
    </div>
</div>

<!-- Description -->
<div class="glass-card p-10 rounded-[3rem] border border-outline-variant/30 mb-stack-lg">
    <h4 class="text-xs uppercase font-black text-on-surface-variant tracking-[0.2em] mb-6">Event Description</h4>
    <p class="text-sm text-on-surface leading-relaxed">{{ $event->description }}</p>
</div>

<!-- Attendee List -->
<div class="glass-card rounded-[3rem] border border-outline-variant/30 overflow-hidden">
    <div class="px-10 py-8 bg-surface-container-low border-b border-outline-variant/20">
        <h4 class="text-xs uppercase font-black text-on-surface tracking-[0.2em]">Registered Attendees</h4>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-surface-container-lowest text-[9px] font-black uppercase tracking-[0.2em] text-on-surface-variant border-b border-outline-variant/10">
                <tr>
                    <th class="px-10 py-5">Attendee</th>
                    <th class="px-10 py-5">Ticket Code</th>
                    <th class="px-10 py-5">Status</th>
                    <th class="px-10 py-5">Registered</th>
                    <th class="px-10 py-5">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($event->tickets as $ticket)
                    <tr class="text-sm hover:bg-surface-container-low/50 transition-colors">
                        <td class="px-10 py-5">
                            <p class="font-bold text-on-surface">{{ $ticket->user->name ?? 'Unknown' }}</p>
                            <p class="text-[10px] text-on-surface-variant opacity-60">{{ $ticket->user->email ?? '' }}</p>
                        </td>
                        <td class="px-10 py-5 font-mono text-xs text-on-surface-variant">{{ $ticket->ticket_code }}</td>
                        <td class="px-10 py-5">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                {{ $ticket->status === 'checked_in' ? 'bg-green-100 text-green-700' : 'bg-primary-container/30 text-primary' }}">
                                {{ str_replace('_', ' ', $ticket->status) }}
                            </span>
                        </td>
                        <td class="px-10 py-5 text-on-surface-variant font-medium opacity-70">{{ $ticket->created_at->format('M d, H:i') }}</td>
                        <td class="px-10 py-5">
                            @if($ticket->status !== 'checked_in')
                                <form action="{{ route('admin.loyalty.events.check-in', $ticket) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-4 py-1.5 bg-green-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-green-700 transition-colors">Check In</button>
                                </form>
                            @else
                                <span class="text-[10px] text-green-600 font-bold italic">Checked In</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-10 py-20 text-center text-on-surface-variant italic">No attendees registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
