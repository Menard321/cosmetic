@extends('layouts.admin')
@section('title', 'Employee Management System')
@section('content')

{{-- Page Header --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">Human Resources</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Employee Management System</h1>
        <p class="text-xs text-on-surface-variant mt-1">Centralized HR control for all Niffer Cosmetic branches</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.ems.employees.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-on-background text-white rounded-xl text-sm font-bold hover:bg-primary transition-all shadow-lg">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            Add Employee
        </a>
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    @php
    $cards = [
        ['label'=>'Total Employees',   'value'=>$stats['total'],          'icon'=>'group',          'color'=>'bg-blue-50 text-blue-700',   'border'=>'border-blue-200'],
        ['label'=>'Active',            'value'=>$stats['active'],         'icon'=>'check_circle',   'color'=>'bg-emerald-50 text-emerald-700','border'=>'border-emerald-200'],
        ['label'=>'On Leave',          'value'=>$stats['on_leave'],       'icon'=>'beach_access',   'color'=>'bg-amber-50 text-amber-700', 'border'=>'border-amber-200'],
        ['label'=>'Present Today',     'value'=>$stats['present_today'],  'icon'=>'how_to_reg',     'color'=>'bg-green-50 text-green-700', 'border'=>'border-green-200'],
        ['label'=>'Absent Today',      'value'=>$stats['absent_today'],   'icon'=>'person_off',     'color'=>'bg-red-50 text-red-700',     'border'=>'border-red-200'],
        ['label'=>'New This Month',    'value'=>$stats['new_this_month'], 'icon'=>'fiber_new',      'color'=>'bg-purple-50 text-purple-700','border'=>'border-purple-200'],
        ['label'=>'Inactive',          'value'=>$stats['inactive'],       'icon'=>'block',          'color'=>'bg-gray-50 text-gray-700',   'border'=>'border-gray-200'],
        ['label'=>'Pending Leaves',    'value'=>$stats['pending_leaves'], 'icon'=>'pending_actions','color'=>'bg-orange-50 text-orange-700','border'=>'border-orange-200'],
        ['label'=>'Payroll This Month','value'=>'TZS '.number_format($stats['total_payroll']), 'icon'=>'payments','color'=>'bg-primary/5 text-primary','border'=>'border-primary/20'],
        ['label'=>'Avg Performance',   'value'=>number_format($stats['avg_performance'],1).'%','icon'=>'insights','color'=>'bg-violet-50 text-violet-700','border'=>'border-violet-200'],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="bg-white border {{ $card['border'] }} rounded-2xl p-4 flex items-center gap-3 hover:shadow-md transition-shadow">
        <div class="w-10 h-10 {{ $card['color'] }} rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">{{ $card['icon'] }}</span>
        </div>
        <div>
            <p class="text-lg font-black text-on-surface leading-none">{{ $card['value'] }}</p>
            <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wide mt-0.5">{{ $card['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Main Grid: Recent Employees + Top Performers --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Recent Employees --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-outline-variant/20 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-on-surface text-sm">Recent Employees</h3>
                <p class="text-[10px] text-on-surface-variant">Latest additions to the team</p>
            </div>
            <a href="{{ route('admin.ems.employees.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">View All</a>
        </div>
        <div class="divide-y divide-outline-variant/10">
            @forelse($recentEmployees as $emp)
            <div class="flex items-center gap-4 px-6 py-3 hover:bg-surface-container-low transition-colors">
                <img src="{{ $emp->photo_url }}" class="w-10 h-10 rounded-full object-cover border-2 border-outline-variant/20" alt="{{ $emp->full_name }}">
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-on-surface text-sm truncate">{{ $emp->full_name }}</p>
                    <p class="text-[10px] text-on-surface-variant truncate">{{ $emp->position }} · {{ $emp->branch?->name ?? 'Unassigned' }}</p>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase
                        {{ $emp->status === 'active' ? 'bg-emerald-100 text-emerald-700' :
                          ($emp->status === 'on_leave' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                        {{ str_replace('_', ' ', $emp->status) }}
                    </span>
                </div>
                <a href="{{ route('admin.ems.employees.show', $emp) }}" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-primary-container/20 text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </a>
            </div>
            @empty
            <div class="px-6 py-12 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl mb-2 block opacity-30">group</span>
                <p class="text-sm">No employees yet.</p>
                <a href="{{ route('admin.ems.employees.create') }}" class="text-primary text-xs font-bold hover:underline mt-1 inline-block">Add First Employee →</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Top Performers --}}
    <div class="bg-white rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-outline-variant/20">
            <h3 class="font-bold text-on-surface text-sm">🏆 Top Performers</h3>
            <p class="text-[10px] text-on-surface-variant">{{ now()->format('F Y') }}</p>
        </div>
        <div class="p-4 space-y-3">
            @forelse($topPerformers as $i => $review)
            <div class="flex items-center gap-3 p-3 rounded-xl {{ $i === 0 ? 'bg-primary/5 border border-primary/20' : 'bg-surface-container-low' }}">
                <div class="w-7 h-7 rounded-full {{ $i === 0 ? 'bg-primary text-white' : 'bg-surface-variant text-on-surface-variant' }} flex items-center justify-center text-xs font-black">
                    {{ $i + 1 }}
                </div>
                <img src="{{ $review->employee->photo_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-on-surface text-xs truncate">{{ $review->employee->full_name }}</p>
                    <p class="text-[9px] text-on-surface-variant">{{ $review->employee->position }}</p>
                </div>
                <div class="text-right">
                    <p class="font-black text-primary text-sm">{{ $review->overall_score }}%</p>
                    <p class="text-[9px] text-on-surface-variant capitalize">{{ $review->rating }}</p>
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-3xl block mb-2 opacity-30">insights</span>
                <p class="text-xs">No reviews this month</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Bottom Grid: Pending Leaves + Transfers + Branch Breakdown --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Pending Leaves --}}
    <div class="bg-white rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-outline-variant/20 flex justify-between items-center">
            <h3 class="font-bold text-on-surface text-sm">⏳ Pending Leave Requests</h3>
            <a href="{{ route('admin.ems.leaves.index') }}" class="text-[10px] font-black text-primary uppercase hover:underline">Manage</a>
        </div>
        <div class="divide-y divide-outline-variant/10">
            @forelse($pendingLeaves as $leave)
            <div class="px-6 py-3">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-bold text-sm text-on-surface">{{ $leave->employee->full_name }}</p>
                        <p class="text-[10px] text-on-surface-variant capitalize">{{ str_replace('_', ' ', $leave->leave_type) }} Leave · {{ $leave->total_days }} day(s)</p>
                        <p class="text-[10px] text-primary mt-1">{{ $leave->start_date->format('M d') }} – {{ $leave->end_date->format('M d, Y') }}</p>
                    </div>
                    <div class="flex gap-1">
                        <form action="{{ route('admin.ems.leaves.approve', $leave) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="w-7 h-7 bg-emerald-100 hover:bg-emerald-500 hover:text-white text-emerald-700 rounded-lg flex items-center justify-center transition-colors" title="Approve">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                            </button>
                        </form>
                        <button onclick="document.getElementById('reject-{{ $leave->id }}').classList.toggle('hidden')"
                            class="w-7 h-7 bg-red-100 hover:bg-red-500 hover:text-white text-red-700 rounded-lg flex items-center justify-center transition-colors" title="Reject">
                            <span class="material-symbols-outlined text-[14px]">close</span>
                        </button>
                    </div>
                </div>
                <div id="reject-{{ $leave->id }}" class="hidden mt-2">
                    <form action="{{ route('admin.ems.leaves.reject', $leave) }}" method="POST" class="flex gap-2">
                        @csrf @method('PATCH')
                        <input name="rejection_reason" placeholder="Reason..." class="flex-1 text-xs border border-outline-variant rounded-lg px-2 py-1" required>
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white text-xs rounded-lg">Reject</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-3xl block mb-2 opacity-30">check_circle</span>
                <p class="text-xs">No pending requests</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Transfers --}}
    <div class="bg-white rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-outline-variant/20">
            <h3 class="font-bold text-on-surface text-sm">🔄 Recent Transfers</h3>
        </div>
        <div class="p-4 space-y-3">
            @forelse($recentTransfers as $transfer)
            <div class="p-3 bg-surface-container-low rounded-xl">
                <p class="font-bold text-xs text-on-surface">{{ $transfer->employee->full_name }}</p>
                <div class="flex items-center gap-2 mt-1 text-[10px] text-on-surface-variant">
                    <span>{{ $transfer->fromBranch->name }}</span>
                    <span class="material-symbols-outlined text-[12px] text-primary">arrow_forward</span>
                    <span class="font-bold text-primary">{{ $transfer->toBranch->name }}</span>
                </div>
                <p class="text-[9px] text-on-surface-variant mt-1">{{ $transfer->transfer_date->format('M d, Y') }}</p>
            </div>
            @empty
            <div class="py-8 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-3xl block mb-2 opacity-30">swap_horiz</span>
                <p class="text-xs">No transfers yet</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Branch Employee Breakdown --}}
    <div class="bg-white rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-outline-variant/20">
            <h3 class="font-bold text-on-surface text-sm">🏢 By Branch</h3>
        </div>
        <div class="p-4 space-y-3">
            @php $totalEmp = max($stats['total'], 1); @endphp
            @foreach($byBranch as $branch)
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-bold text-on-surface truncate">{{ $branch->name }}</span>
                    <span class="font-black text-primary">{{ $branch->employees_count }}</span>
                </div>
                <div class="w-full bg-surface-container-high rounded-full h-2">
                    <div class="bg-primary h-2 rounded-full transition-all duration-700"
                         style="width: {{ min(100, round(($branch->employees_count / $totalEmp) * 100)) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- EMS Quick Nav --}}
        <div class="px-4 pb-4 grid grid-cols-2 gap-2 mt-2">
            <a href="{{ route('admin.ems.attendance.index') }}" class="flex items-center gap-2 p-2 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-colors">
                <span class="material-symbols-outlined text-[16px]">how_to_reg</span>
                <span class="text-[10px] font-black uppercase">Attendance</span>
            </a>
            <a href="{{ route('admin.ems.payroll.index') }}" class="flex items-center gap-2 p-2 bg-emerald-50 text-emerald-700 rounded-xl hover:bg-emerald-100 transition-colors">
                <span class="material-symbols-outlined text-[16px]">payments</span>
                <span class="text-[10px] font-black uppercase">Payroll</span>
            </a>
            <a href="{{ route('admin.ems.performance.index') }}" class="flex items-center gap-2 p-2 bg-violet-50 text-violet-700 rounded-xl hover:bg-violet-100 transition-colors">
                <span class="material-symbols-outlined text-[16px]">insights</span>
                <span class="text-[10px] font-black uppercase">Performance</span>
            </a>
            <a href="{{ route('admin.ems.leaves.index') }}" class="flex items-center gap-2 p-2 bg-amber-50 text-amber-700 rounded-xl hover:bg-amber-100 transition-colors">
                <span class="material-symbols-outlined text-[16px]">beach_access</span>
                <span class="text-[10px] font-black uppercase">Leaves</span>
            </a>
        </div>
    </div>
</div>

@endsection
