<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Show the consultation booking form.
     */
    public function create()
    {
        return view('consultation.book');
    }

    /**
     * Store a new consultation booking in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone_number'   => 'required|string|max:20',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required|string',
            'skin_type'      => 'nullable|string|in:Oily,Dry,Combination,Sensitive',
            'concerns'       => 'nullable|string|max:2000',
        ]);

        $validated['status'] = Consultation::STATUS_PENDING;

        Consultation::create($validated);

        return redirect()->route('home')
            ->with('success', 'Your consultation request has been submitted! We will confirm your appointment within 24 hours.');
    }

    /**
     * Admin: List all consultations with stats.
     */
    public function adminIndex()
    {
        $consultations = Consultation::latest()->paginate(15);

        return view('admin.consultations', [
            'consultations' => $consultations,
            'pending'       => Consultation::where('status', Consultation::STATUS_PENDING)->count(),
            'confirmed'     => Consultation::where('status', Consultation::STATUS_CONFIRMED)->count(),
            'completed'     => Consultation::where('status', Consultation::STATUS_COMPLETED)->count(),
            'rejected'      => Consultation::where('status', 'rejected')->count(),
        ]);
    }

    /**
     * Admin: Update the status of a consultation (confirm / reject / complete).
     */
    public function updateStatus(Request $request, Consultation $consultation)
    {
        $request->validate([
            'status' => 'required|in:confirmed,rejected,completed',
        ]);

        $consultation->update(['status' => $request->status]);

        $messages = [
            'confirmed' => 'Consultation booking has been confirmed.',
            'rejected'  => 'Consultation booking has been rejected.',
            'completed' => 'Consultation has been marked as completed.',
        ];

        return back()->with('success', $messages[$request->status] ?? 'Status updated.');
    }
}

