@extends('layouts.admin')
@section('title', 'Leave Management')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">EMS · HR</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Leave Management</h1>
    </div>
    <button onclick="document.getElementById('new-leave-modal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-on-background text-white rounded-xl text-sm font-bold hover:bg-primary transition-all">
        <span class="material-symbols-outlined text-[18px]">add</span> New Leave Request
    </button>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([['label'=>'Pending','value'=>$stats['pending'],'color'=>'amber'],['label'=>'Approved','value'=>$stats['approved'],'color'=>'emerald'],['label'=>'Rejected','value'=>$stats['rejected'],'color'=>'red'],['label'=>'This Month','value'=>$stats['this_month'],'color'=>'blue']] as $s)
    <div class="bg-white border border-{{ $s['color'] }}-200 rounded-2xl p-4 shadow-sm">
        <p class="text-2xl font-black text-{{ $s['color'] }}-600">{{ $s['value'] }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl p-4 mb-6 shadow-sm">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <select name="status" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            <option value="">All Status</option>
            @foreach(['pending','approved','rejected','manager_approved'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>@endforeach
        </select>
        <select name="leave_type" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            <option value="">All Types</option>
            @foreach(['annual','sick','maternity','emergency','unpaid'] as $t)<option value="{{ $t }}" {{ request('leave_type')==$t?'selected':'' }}>{{ ucfirst($t) }}</option>@endforeach
        </select>
        <select name="branch_id" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            <option value="">All Branches</option>
            @foreach($branches as $b)<option value="{{ $b->id }}" {{ request('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
        </select>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-primary text-white rounded-xl py-2 text-sm font-bold">Filter</button>
            <a href="{{ route('admin.ems.leaves.index') }}" class="px-3 py-2 bg-surface-container-high rounded-xl text-sm">✕</a>
        </div>
    </form>
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="px-6 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Employee</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Type</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Period</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Days</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Status</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($requests as $leave)
                <tr class="hover:bg-surface-container-low">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $leave->employee->photo_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                            <div>
                                <p class="font-bold text-on-surface">{{ $leave->employee->full_name }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ $leave->employee->branch?->name ?? 'HQ' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[9px] font-black uppercase">{{ str_replace('_',' ',$leave->leave_type) }}</span></td>
                    <td class="px-4 py-3 text-on-surface-variant">{{ $leave->start_date->format('M d') }} – {{ $leave->end_date->format('M d, Y') }}</td>
                    <td class="px-4 py-3 font-black text-primary">{{ $leave->total_days }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase {{ $leave->status==='approved'?'bg-emerald-100 text-emerald-700':($leave->status==='rejected'?'bg-red-100 text-red-700':'bg-amber-100 text-amber-700') }}">
                            {{ str_replace('_',' ',$leave->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            @if($leave->status === 'pending')
                            <form action="{{ route('admin.ems.leaves.approve', $leave) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="px-3 py-1 bg-emerald-100 hover:bg-emerald-500 hover:text-white text-emerald-700 rounded-lg text-[10px] font-black uppercase transition-colors">Approve</button>
                            </form>
                            <form action="{{ route('admin.ems.leaves.reject', $leave) }}" method="POST">
                                @csrf @method('PATCH')
                                <input name="rejection_reason" placeholder="Reason" class="w-24 border border-outline-variant rounded px-2 py-1 text-xs" required>
                                <button class="px-3 py-1 bg-red-100 hover:bg-red-500 hover:text-white text-red-700 rounded-lg text-[10px] font-black uppercase transition-colors ml-1">Reject</button>
                            </form>
                            @else
                            <span class="text-xs text-on-surface-variant">{{ $leave->status === 'approved' ? 'Approved ✓' : 'Rejected ✗' }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">No leave requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($requests->hasPages())<div class="px-6 py-4 border-t border-outline-variant/20">{{ $requests->links() }}</div>@endif
</div>

{{-- New Leave Modal --}}
<div id="new-leave-modal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-on-surface">New Leave Request</h3>
            <button onclick="document.getElementById('new-leave-modal').classList.add('hidden')" class="w-8 h-8 bg-surface-container-high rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
        </div>
        <form action="{{ route('admin.ems.leaves.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Employee</label>
                <select name="employee_id" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm">
                    <option value="">Select employee</option>
                    @foreach(\App\Models\Employee::where('status','active')->orderBy('full_name')->get() as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->full_name }} — {{ $emp->position }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Leave Type</label>
                <select name="leave_type" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm">
                    @foreach(['annual','sick','maternity','emergency','unpaid','other'] as $t)<option value="{{ $t }}">{{ ucfirst($t) }} Leave</option>@endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Start Date</label>
                    <input type="date" name="start_date" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">End Date</label>
                    <input type="date" name="end_date" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Reason</label>
                <textarea name="reason" rows="3" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm" placeholder="Reason for leave request..."></textarea>
            </div>
            <button type="submit" class="w-full py-3 bg-primary text-white rounded-xl font-bold hover:bg-on-background transition-all">Submit Request</button>
        </form>
    </div>
</div>
@endsection
