@extends('layouts.admin')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div id="flash-success" class="fixed top-6 right-6 z-[9999] flex items-center gap-3 bg-on-background text-white px-6 py-4 shadow-2xl border-l-4 border-primary">
    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
    <p class="font-label-md">{{ session('success') }}</p>
    <button onclick="document.getElementById('flash-success').remove()" class="ml-4 text-white/60 hover:text-white">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
@endif

{{-- Page Header --}}
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Consultation Bookings</h2>
        <p class="font-body-md text-on-surface-variant">Review, approve, or reject customer consultation requests.</p>
    </div>
    <div class="flex gap-3">
        <span class="flex items-center gap-2 px-4 py-2 bg-primary-container/20 border border-primary/30 rounded-xl">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            <span class="font-label-md text-primary">{{ $pending }} Pending</span>
        </span>
    </div>
</div>

{{-- Stats Row --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-stack-lg">
    <div class="glass-card p-5 rounded-xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
        <div class="p-3 bg-primary-container/20 rounded-lg">
            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">pending_actions</span>
        </div>
        <div>
            <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Pending</p>
            <h3 class="font-headline-sm text-headline-sm">{{ $pending }}</h3>
        </div>
    </div>
    <div class="glass-card p-5 rounded-xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
        <div class="p-3 bg-secondary-container rounded-lg">
            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">how_to_reg</span>
        </div>
        <div>
            <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Confirmed</p>
            <h3 class="font-headline-sm text-headline-sm">{{ $confirmed }}</h3>
        </div>
    </div>
    <div class="glass-card p-5 rounded-xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
        <div class="p-3 bg-tertiary-container/30 rounded-lg">
            <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">task_alt</span>
        </div>
        <div>
            <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Completed</p>
            <h3 class="font-headline-sm text-headline-sm">{{ $completed }}</h3>
        </div>
    </div>
    <div class="glass-card p-5 rounded-xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
        <div class="p-3 bg-error-container/30 rounded-lg">
            <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">cancel</span>
        </div>
        <div>
            <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Rejected</p>
            <h3 class="font-headline-sm text-headline-sm">{{ $rejected }}</h3>
        </div>
    </div>
</div>

{{-- Filter Tabs --}}
<div class="glass-card rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-outline-variant/20 flex flex-wrap gap-2 items-center justify-between">
        <div class="flex gap-2 flex-wrap" id="filterTabs">
            @foreach(['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'completed' => 'Completed', 'rejected' => 'Rejected'] as $val => $label)
            <button
                onclick="filterTable('{{ $val }}')"
                id="tab-{{ $val }}"
                class="filter-tab px-4 py-2 rounded-lg font-label-sm uppercase tracking-wider text-sm transition-all
                    {{ $val === 'all' ? 'bg-on-background text-white' : 'border border-outline-variant text-on-surface-variant hover:bg-surface-container' }}"
            >
                {{ $label }}
                @if($val === 'pending' && $pending > 0)
                <span class="ml-1 bg-primary text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $pending }}</span>
                @endif
            </button>
            @endforeach
        </div>
        <p class="font-label-sm text-on-surface-variant" id="tableCount">Showing {{ $consultations->count() }} bookings</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left" id="consultationsTable">
            <thead class="bg-surface-container-low text-on-surface-variant font-label-sm">
                <tr>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Appointment</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Skin Type</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/30">
                @forelse($consultations as $consultation)
                <tr class="hover:bg-surface-container-low transition-colors consultation-row" data-status="{{ $consultation->status }}">
                    <td class="px-6 py-5 font-label-sm text-on-surface-variant">#{{ $consultation->id }}</td>

                    {{-- Customer --}}
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-primary-container/30 flex items-center justify-center font-bold text-primary text-sm">
                                {{ strtoupper(substr($consultation->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-label-md font-semibold text-on-surface">{{ $consultation->name }}</p>
                                <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Submitted {{ $consultation->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Contact --}}
                    <td class="px-6 py-5">
                        <p class="font-label-sm text-on-surface">{{ $consultation->email }}</p>
                        <p class="font-label-sm text-on-surface-variant">{{ $consultation->phone_number }}</p>
                    </td>

                    {{-- Appointment --}}
                    <td class="px-6 py-5">
                        <p class="font-label-md font-semibold text-on-surface">
                            {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M d, Y') }}
                        </p>
                        <p class="font-label-sm text-primary">{{ $consultation->preferred_time }}</p>
                    </td>

                    {{-- Skin Type --}}
                    <td class="px-6 py-5">
                        @if($consultation->skin_type)
                            <span class="px-2 py-1 bg-surface-container-highest text-on-surface text-[10px] rounded uppercase font-bold">
                                {{ $consultation->skin_type }}
                            </span>
                        @else
                            <span class="text-on-surface-variant text-xs italic">Not specified</span>
                        @endif
                    </td>

                    {{-- Status Badge --}}
                    <td class="px-6 py-5">
                        @php
                            $statusStyles = [
                                'pending'   => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                                'confirmed' => 'bg-blue-100 text-blue-800 border border-blue-300',
                                'completed' => 'bg-green-100 text-green-800 border border-green-300',
                                'rejected'  => 'bg-red-100 text-red-800 border border-red-300',
                            ];
                            $statusIcons = [
                                'pending'   => 'pending',
                                'confirmed' => 'how_to_reg',
                                'completed' => 'task_alt',
                                'rejected'  => 'cancel',
                            ];
                        @endphp
                        <span class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider w-fit {{ $statusStyles[$consultation->status] ?? 'bg-surface-container' }}">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">{{ $statusIcons[$consultation->status] ?? 'info' }}</span>
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2 flex-wrap">
                            {{-- View Details Button --}}
                            <button
                                onclick="openModal({{ $consultation->id }}, '{{ addslashes($consultation->name) }}', '{{ addslashes($consultation->email) }}', '{{ addslashes($consultation->phone_number) }}', '{{ $consultation->preferred_date }}', '{{ $consultation->preferred_time }}', '{{ $consultation->skin_type ?? 'Not specified' }}', `{{ addslashes($consultation->concerns ?? 'No concerns listed.') }}`, '{{ $consultation->status }}')"
                                class="p-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-colors"
                                title="View Details"
                            >
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </button>

                            @if($consultation->status === 'pending')
                            {{-- Confirm --}}
                            <form action="{{ route('admin.consultations.updateStatus', $consultation->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed" />
                                <button type="submit" class="px-3 py-2 bg-on-background text-white rounded-lg font-label-sm text-xs hover:bg-primary transition-colors flex items-center gap-1" title="Confirm">
                                    <span class="material-symbols-outlined text-sm">check</span> Confirm
                                </button>
                            </form>

                            {{-- Reject --}}
                            <form action="{{ route('admin.consultations.updateStatus', $consultation->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected" />
                                <button type="submit" class="px-3 py-2 bg-error text-white rounded-lg font-label-sm text-xs hover:opacity-90 transition-opacity flex items-center gap-1" title="Reject">
                                    <span class="material-symbols-outlined text-sm">close</span> Reject
                                </button>
                            </form>
                            @endif

                            @if($consultation->status === 'confirmed')
                            {{-- Mark Completed --}}
                            <form action="{{ route('admin.consultations.updateStatus', $consultation->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed" />
                                <button type="submit" class="px-3 py-2 bg-secondary text-white rounded-lg font-label-sm text-xs hover:opacity-90 flex items-center gap-1" title="Mark Completed">
                                    <span class="material-symbols-outlined text-sm">task_alt</span> Done
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-5xl block mb-4 text-outline">event_busy</span>
                        <p class="font-label-md uppercase tracking-widest">No consultation bookings yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($consultations->hasPages())
    <div class="p-6 border-t border-outline-variant/20">
        {{ $consultations->links() }}
    </div>
    @endif
</div>

{{-- Detail Modal --}}
<div id="detailModal" class="fixed inset-0 z-[9998] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative bg-white w-full max-w-lg mx-4 shadow-2xl z-10 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-8 py-6 border-b border-outline-variant/20 bg-on-background text-white">
            <div>
                <h3 class="font-headline-sm text-headline-sm" id="modal-name">Customer Name</h3>
                <p class="text-white/60 text-xs uppercase tracking-wider">Consultation Booking Details</p>
            </div>
            <button onclick="closeModal()" class="text-white/60 hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-8 space-y-5">
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Email</p>
                    <p class="font-body-md text-on-surface" id="modal-email">—</p>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Phone</p>
                    <p class="font-body-md text-on-surface" id="modal-phone">—</p>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Preferred Date</p>
                    <p class="font-body-md text-on-surface font-semibold" id="modal-date">—</p>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Preferred Time</p>
                    <p class="font-body-md text-primary font-semibold" id="modal-time">—</p>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Skin Type</p>
                    <p class="font-body-md text-on-surface" id="modal-skin">—</p>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Status</p>
                    <p class="font-body-md font-bold" id="modal-status">—</p>
                </div>
            </div>
            <div>
                <p class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-2">Concerns / Notes</p>
                <div class="bg-surface-container-low border border-outline-variant/30 p-4 rounded-lg">
                    <p class="font-body-md text-on-surface leading-relaxed" id="modal-concerns">—</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ── Filter Table ──────────────────────────────────────────
function filterTable(status) {
    const rows = document.querySelectorAll('.consultation-row');
    let count = 0;
    rows.forEach(row => {
        const match = status === 'all' || row.dataset.status === status;
        row.style.display = match ? '' : 'none';
        if (match) count++;
    });
    document.getElementById('tableCount').textContent = `Showing ${count} booking${count !== 1 ? 's' : ''}`;

    // Update active tab
    document.querySelectorAll('.filter-tab').forEach(btn => {
        btn.classList.remove('bg-on-background', 'text-white');
        btn.classList.add('border', 'border-outline-variant', 'text-on-surface-variant');
    });
    const active = document.getElementById('tab-' + status);
    if (active) {
        active.classList.add('bg-on-background', 'text-white');
        active.classList.remove('border', 'border-outline-variant', 'text-on-surface-variant');
    }
}

// ── Detail Modal ──────────────────────────────────────────
function openModal(id, name, email, phone, date, time, skin, concerns, status) {
    document.getElementById('modal-name').textContent = name;
    document.getElementById('modal-email').textContent = email;
    document.getElementById('modal-phone').textContent = phone;
    document.getElementById('modal-date').textContent = date;
    document.getElementById('modal-time').textContent = time;
    document.getElementById('modal-skin').textContent = skin;
    document.getElementById('modal-concerns').textContent = concerns || 'No concerns listed.';

    const statusColors = { pending: '#b45309', confirmed: '#1d4ed8', completed: '#15803d', rejected: '#dc2626' };
    const statusEl = document.getElementById('modal-status');
    statusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);
    statusEl.style.color = statusColors[status] || '#000';

    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Auto-dismiss flash
setTimeout(() => {
    const flash = document.getElementById('flash-success');
    if (flash) { flash.style.opacity = '0'; setTimeout(() => flash.remove(), 400); }
}, 5000);
</script>

@endsection
