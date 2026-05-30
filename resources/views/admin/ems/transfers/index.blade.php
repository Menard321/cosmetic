@extends('layouts.admin')
@section('title', 'Employee Transfers')
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">Human Resources</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Employee Transfers</h1>
        <p class="text-xs text-on-surface-variant mt-1">Manage staff movements between different branches</p>
    </div>
    <button onclick="document.getElementById('transfer-modal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-on-background text-white rounded-xl text-sm font-bold hover:bg-primary transition-all shadow-lg">
        <span class="material-symbols-outlined text-[18px]">swap_horiz</span>
        Initiate Transfer
    </button>
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-surface-container-low border-b border-outline-variant/20">
                <th class="px-6 py-4 text-[10px] uppercase font-black text-on-surface-variant tracking-wider">Employee</th>
                <th class="px-6 py-4 text-[10px] uppercase font-black text-on-surface-variant tracking-wider">From</th>
                <th class="px-6 py-4 text-[10px] uppercase font-black text-on-surface-variant tracking-wider">To</th>
                <th class="px-6 py-4 text-[10px] uppercase font-black text-on-surface-variant tracking-wider">Date</th>
                <th class="px-6 py-4 text-[10px] uppercase font-black text-on-surface-variant tracking-wider">Status</th>
                <th class="px-6 py-4 text-[10px] uppercase font-black text-on-surface-variant tracking-wider text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant/10">
            @forelse($transfers as $transfer)
            <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ $transfer->employee->photo_url }}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-bold text-sm text-on-surface">{{ $transfer->employee->full_name }}</p>
                            <p class="text-[10px] text-on-surface-variant">{{ $transfer->employee->position }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-medium text-on-surface-variant">{{ $transfer->fromBranch->name ?? 'HQ' }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-bold text-primary">{{ $transfer->toBranch->name }}</span>
                </td>
                <td class="px-6 py-4">
                    <p class="text-xs text-on-surface font-medium">{{ $transfer->transfer_date->format('M d, Y') }}</p>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase
                        {{ $transfer->status === 'completed' ? 'bg-emerald-100 text-emerald-700' :
                           ($transfer->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                        {{ $transfer->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    @if($transfer->status === 'pending')
                    <div class="flex justify-end gap-2">
                        <form action="{{ route('admin.ems.transfers.approve', $transfer) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all" title="Approve & Execute">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </button>
                        </form>
                        <form action="{{ route('admin.ems.transfers.cancel', $transfer) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all" title="Cancel Request">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                            </button>
                        </form>
                    </div>
                    @else
                    <span class="text-[10px] text-on-surface-variant">
                        @if($transfer->approvedBy)
                        By {{ $transfer->approvedBy->name }} on {{ $transfer->approved_at->format('M d') }}
                        @else
                        Processed
                        @endif
                    </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-20 text-center">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant/20 mb-2">swap_horiz</span>
                    <p class="text-sm text-on-surface-variant italic">No transfer records found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($transfers->hasPages())
    <div class="px-6 py-4 border-t border-outline-variant/10">
        {{ $transfers->links() }}
    </div>
    @endif
</div>

{{-- Transfer Modal --}}
<div id="transfer-modal" class="fixed inset-0 bg-on-background/20 backdrop-blur-sm z-[100] flex items-center justify-center hidden">
    <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-4 bg-surface-container flex justify-between items-center border-b border-outline-variant/20">
            <h3 class="font-bold text-on-surface">Initiate Employee Transfer</h3>
            <button onclick="document.getElementById('transfer-modal').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="{{ route('admin.ems.transfers.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Select Employee *</label>
                <select name="employee_id" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                    <option value="">Choose an employee...</option>
                    @foreach($employees as $e)
                    <option value="{{ $e->id }}">{{ $e->full_name }} ({{ $e->branch?->name ?? 'HQ' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Destination Branch *</label>
                <select name="to_branch_id" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                    <option value="">Target branch...</option>
                    @foreach($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Effective Date *</label>
                <input type="date" name="transfer_date" value="{{ date('Y-m-d') }}" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
            </div>

            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Reason for Transfer *</label>
                <textarea name="reason" rows="3" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="e.g. Branch expansion, staff optimization..."></textarea>
            </div>

            <div class="pt-4 flex gap-2">
                <button type="submit" class="flex-1 py-3.5 bg-primary text-white rounded-xl font-bold text-sm hover:shadow-lg transition-all shadow-primary/20 uppercase tracking-widest">Submit Request</button>
                <button type="button" onclick="document.getElementById('transfer-modal').classList.add('hidden')" class="px-6 py-3.5 bg-surface-container-high text-on-surface rounded-xl font-bold text-sm hover:bg-surface-variant transition-all">Cancel</button>
            </div>
        </form>
    </div>
</div>

@endsection
