@extends('layouts.admin')
@section('title', 'Shift Management')
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">Human Resources</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Shift Management</h1>
        <p class="text-xs text-on-surface-variant mt-1">Configure working hours and break times for different branches</p>
    </div>
    <button onclick="document.getElementById('shift-modal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-on-background text-white rounded-xl text-sm font-bold hover:bg-primary transition-all shadow-lg">
        <span class="material-symbols-outlined text-[18px]">schedule</span>
        Create Shift
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($shifts as $shift)
    <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-12 -mt-12 transition-all group-hover:bg-primary/10"></div>
        
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="font-bold text-on-surface text-lg">{{ $shift->name }}</h3>
                <p class="text-[10px] text-primary font-black uppercase tracking-widest">{{ $shift->branch?->name ?? 'Global Shift' }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="editShift({{ $shift }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container-high text-on-surface-variant hover:bg-primary hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                </button>
                <form action="{{ route('admin.ems.shifts.destroy', $shift) }}" method="POST" onsubmit="return confirm('Delete this shift?')">
                    @csrf @method('DELETE')
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-3 relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                </div>
                <div>
                    <p class="text-[10px] text-on-surface-variant font-bold uppercase">Timing</p>
                    <p class="text-sm font-black text-on-surface">{{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">coffee</span>
                </div>
                <div>
                    <p class="text-[10px] text-on-surface-variant font-bold uppercase">Break Duration</p>
                    <p class="text-sm font-black text-on-surface">{{ $shift->break_minutes }} Minutes</p>
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant/10 flex justify-between items-center">
                <span class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">{{ $shift->duration_hours }} Hours Total</span>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $shift->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $shift->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>
    @empty
    <div class="md:col-span-3 py-20 text-center bg-white rounded-3xl border border-dashed border-outline-variant/50">
        <span class="material-symbols-outlined text-5xl text-on-surface-variant/20 mb-4">schedule</span>
        <p class="text-on-surface-variant font-bold">No shifts configured yet.</p>
        <button onclick="document.getElementById('shift-modal').classList.remove('hidden')" class="mt-4 text-primary font-black uppercase tracking-widest text-xs hover:underline">Add Your First Shift</button>
    </div>
    @endforelse
</div>

{{-- Shift Create/Edit Modal --}}
<div id="shift-modal" class="fixed inset-0 bg-on-background/20 backdrop-blur-sm z-[100] flex items-center justify-center hidden">
    <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-4 bg-surface-container flex justify-between items-center border-b border-outline-variant/20">
            <h3 class="font-bold text-on-surface" id="modal-title">Create New Shift</h3>
            <button onclick="document.getElementById('shift-modal').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form id="shift-form" action="{{ route('admin.ems.shifts.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div id="method-field"></div>
            
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Shift Name *</label>
                <input name="name" id="shift-name" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="e.g. Morning Shift">
            </div>

            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Branch (Optional)</label>
                <select name="branch_id" id="shift-branch" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                    <option value="">Global (All Branches)</option>
                    @foreach($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Start Time *</label>
                    <input type="time" name="start_time" id="shift-start" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">End Time *</label>
                    <input type="time" name="end_time" id="shift-end" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Break Duration (Minutes)</label>
                <input type="number" name="break_minutes" id="shift-break" value="30" min="0" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="shift-active" checked value="1" class="w-4 h-4 text-primary rounded border-outline-variant focus:ring-primary/20">
                <label class="text-xs font-bold text-on-surface-variant uppercase">Active Shift</label>
            </div>

            <div class="pt-4 flex gap-2">
                <button type="submit" class="flex-1 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:shadow-lg transition-all shadow-primary/20 uppercase tracking-widest">Save Shift</button>
                <button type="button" onclick="document.getElementById('shift-modal').classList.add('hidden')" class="px-6 py-3 bg-surface-container-high text-on-surface rounded-xl font-bold text-sm hover:bg-surface-variant transition-all">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function editShift(shift) {
    const modal = document.getElementById('shift-modal');
    const form = document.getElementById('shift-form');
    const title = document.getElementById('modal-title');
    const methodField = document.getElementById('method-field');

    title.textContent = 'Edit Shift';
    form.action = `/admin/ems/shifts/${shift.id}`;
    methodField.innerHTML = '<input type="hidden" name="_method" value="PATCH">';
    
    document.getElementById('shift-name').value = shift.name;
    document.getElementById('shift-branch').value = shift.branch_id || '';
    document.getElementById('shift-start').value = shift.start_time.substring(0, 5);
    document.getElementById('shift-end').value = shift.end_time.substring(0, 5);
    document.getElementById('shift-break').value = shift.break_minutes;
    document.getElementById('shift-active').checked = shift.is_active;

    modal.classList.remove('hidden');
}

// Reset modal on open for "Create"
document.querySelector('[onclick*="shift-modal"]').addEventListener('click', () => {
    if (document.getElementById('modal-title').textContent === 'Edit Shift') {
        document.getElementById('modal-title').textContent = 'Create New Shift';
        document.getElementById('shift-form').action = "{{ route('admin.ems.shifts.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('shift-form').reset();
    }
});
</script>

@endsection
