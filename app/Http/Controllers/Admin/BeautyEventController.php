<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeautyEvent;
use Illuminate\Http\Request;

class BeautyEventController extends Controller
{
    public function index()
    {
        $events = BeautyEvent::withCount('tickets')->orderBy('event_date', 'desc')->get();
        return view('admin.loyalty.events.index', compact('events'));
    }

    public function create()
    {
        $branches = \App\Models\Branch::all();
        return view('admin.loyalty.events.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'branch_id' => 'nullable|exists:branches,id',
            'max_attendees' => 'required|integer|min:1',
            'points_required' => 'nullable|integer|min:0',
        ]);

        BeautyEvent::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'capacity' => $request->max_attendees,
            'points_required' => $request->points_required ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.loyalty.events.index')
            ->with('success', 'Beauty event created successfully.');
    }

    public function show(BeautyEvent $event)
    {
        $event->load('tickets.user');
        return view('admin.loyalty.events.show', compact('event'));
    }

    public function edit(BeautyEvent $event)
    {
        $branches = \App\Models\Branch::all();
        return view('admin.loyalty.events.edit', compact('event', 'branches'));
    }

    public function update(Request $request, BeautyEvent $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'max_attendees' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'capacity' => $request->max_attendees,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.loyalty.events.index')
            ->with('success', 'Event updated.');
    }

    public function destroy(BeautyEvent $event)
    {
        $event->delete();
        return redirect()->route('admin.loyalty.events.index')
            ->with('success', 'Event removed.');
    }
    public function checkInTicket(\App\Models\EventTicket $ticket)
    {
        $ticket->update([
            'status' => 'checked_in',
            'redeemed_at' => now(),
        ]);

        return back()->with('success', "Attendee {$ticket->user->name} checked in successfully.");
    }
}
