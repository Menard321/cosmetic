@extends('layouts.admin')
@section('title', 'Shift Assignments')
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">Human Resources</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Shift Assignment</h1>
        <p class="text-xs text-on-surface-variant mt-1">Assign work schedules to employees for specific periods</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Assignment Form --}}
    <div class="lg:col-span-1">
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm sticky top-6">
            <h3 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">person_add</span> Create Assignment
            </h3>
            <form action="{{ route('admin.ems.shifts.assignments.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Employee *</label>
                    <select name="employee_id" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        <option value="">Select Employee</option>
                        @foreach($employees as $e)
                        <option value="{{ $e->id }}">{{ $e->full_name }} ({{ $e->branch?->name ?? 'HQ' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Shift *</label>
                    <select name="shift_id" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        <option value="">Select Shift</option>
                        @foreach($shifts as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">From *</label>
                        <input type="date" name="effective_from" value="{{ date('Y-m-d') }}" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Until (Optional)</label>
                        <input type="date" name="effective_until" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-on-background text-white rounded-xl font-bold text-sm hover:bg-primary transition-all shadow-lg flex items-center justify-center gap-2 uppercase tracking-widest mt-2">
                    <span class="material-symbols-outlined text-[18px]">add_task</span>
                    Assign Shift
                </button>
            </form>
        </div>
    </div>

    {{-- Assignments Table --}}
    <div class="lg:col-span-2">
        <div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-outline-variant/20 flex justify-between items-center bg-surface-container-low">
                <h3 class="font-bold text-on-surface text-sm">Active & Upcoming Assignments</h3>
                <span class="text-[10px] font-black uppercase text-on-surface-variant">{{ $assignments->total() }} total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-6 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Employee</th>
                            <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Shift</th>
                            <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Period</th>
                            <th class="px-4 py-3 text-right text-[10px] font-black uppercase text-on-surface-variant">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($assignments as $as)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-on-surface">{{ $as->full_name }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <div>
                                    <p class="font-bold text-primary">{{ $as->shift_name }}</p>
                                    <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter">{{ \Carbon\Carbon::parse($as->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($as->end_time)->format('h:i A') }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="font-medium text-on-surface">{{ \Carbon\Carbon::parse($as->effective_from)->format('M d') }}</span>
                                    <span class="text-on-surface-variant">→</span>
                                    <span class="font-medium text-on-surface">{{ $as->effective_until ? \Carbon\Carbon::parse($as->effective_until)->format('M d, Y') : 'Ongoing' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <form action="{{ route('admin.ems.shifts.assignments.destroy', $as->id) }}" method="POST" onsubmit="return confirm('Remove this shift assignment?')">
                                    @csrf @method('DELETE')
                                    <button class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center text-on-surface-variant italic">No shift assignments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($assignments->hasPages())
            <div class="px-6 py-4 border-t border-outline-variant/10">
                {{ $assignments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
