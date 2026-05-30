@extends('layouts.admin')
@section('title', 'HR Reports & Analytics')
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">EMS · Intelligence</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">HR Reports & Analytics</h1>
        <p class="text-xs text-on-surface-variant mt-1">Monitor staff attendance, payroll distribution, and operational efficiency</p>
    </div>
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl p-6 mb-8 shadow-sm">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-[10px] font-black uppercase text-on-surface-variant mb-1">Branch</label>
            <select name="branch_id" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm">
                <option value="">All Branches</option>
                @foreach($branches as $b)
                <option value="{{ $b->id }}" {{ request('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-black uppercase text-on-surface-variant mb-1">Month</label>
            <select name="month" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm">
                @for($m=1;$m<=12;$m++)
                <option value="{{ $m }}" {{ $month==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-black uppercase text-on-surface-variant mb-1">Year</label>
            <select name="year" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm">
                @for($y=2024;$y<=2030;$y++)
                <option value="{{ $y }}" {{ $year==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:shadow-lg transition-all">Generate Report</button>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Payroll Summary --}}
    <div class="bg-white border border-outline-variant/30 rounded-3xl p-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16"></div>
        <h3 class="font-bold text-on-surface mb-6 flex items-center gap-2 relative z-10">
            <span class="material-symbols-outlined text-emerald-600 text-[20px]">payments</span> Payroll Distribution
        </h3>
        <div class="space-y-6 relative z-10">
            <div>
                <p class="text-3xl font-black text-on-surface">{{ number_format($payrollStats->total_net ?? 0) }} <span class="text-xs text-on-surface-variant">TZS</span></p>
                <p class="text-xs text-on-surface-variant font-bold uppercase tracking-widest mt-1">Total Net Expenditure</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-surface-container-low rounded-2xl p-4">
                    <p class="font-bold text-on-surface">{{ number_format($payrollStats->total_bonuses ?? 0) }}</p>
                    <p class="text-[9px] text-on-surface-variant font-black uppercase mt-1">Total Bonuses</p>
                </div>
                <div class="bg-surface-container-low rounded-2xl p-4">
                    <p class="font-bold text-on-surface">{{ $payrollStats->staff_count ?? 0 }}</p>
                    <p class="text-[9px] text-on-surface-variant font-black uppercase mt-1">Staff Paid</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance Overview --}}
    <div class="bg-white border border-outline-variant/30 rounded-3xl p-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16"></div>
        <h3 class="font-bold text-on-surface mb-6 flex items-center gap-2 relative z-10">
            <span class="material-symbols-outlined text-blue-600 text-[20px]">fact_check</span> Attendance Summary
        </h3>
        <div class="space-y-4 relative z-10">
            @php
                $totalAtt = $attendanceStats->sum('count') ?: 1;
            @endphp
            @foreach($attendanceStats as $stat)
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">{{ $stat->status }}</span>
                    <span class="text-xs font-bold">{{ round(($stat->count / $totalAtt) * 100) }}%</span>
                </div>
                <div class="w-full bg-surface-container-low rounded-full h-2">
                    <div class="h-2 rounded-full {{ $stat->status==='present'?'bg-emerald-500':($stat->status==='absent'?'bg-red-500':'bg-amber-500') }}" style="width: {{ ($stat->count / $totalAtt) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
            @if($attendanceStats->isEmpty())
            <div class="py-10 text-center text-on-surface-variant italic text-sm">No records for this period.</div>
            @endif
        </div>
    </div>

    {{-- Leave Distribution --}}
    <div class="bg-white border border-outline-variant/30 rounded-3xl p-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -mr-16 -mt-16"></div>
        <h3 class="font-bold text-on-surface mb-6 flex items-center gap-2 relative z-10">
            <span class="material-symbols-outlined text-amber-600 text-[20px]">beach_access</span> Leaves Taken
        </h3>
        <div class="space-y-3 relative z-10 font-bold text-xs">
            @foreach($leaveStats as $l)
            <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                <span class="capitalize">{{ str_replace('_',' ',$l->leave_type) }}</span>
                <span class="text-primary">{{ $l->total_days }} Days</span>
            </div>
            @endforeach
            @if($leaveStats->isEmpty())
            <div class="py-10 text-center text-on-surface-variant italic text-sm">No leaves recorded.</div>
            @endif
        </div>
    </div>
</div>

<div class="bg-white border border-outline-variant/30 rounded-3xl overflow-hidden shadow-sm">
    <div class="px-6 py-4 bg-surface-container-low border-b border-outline-variant/20 flex justify-between items-center">
        <h3 class="font-bold text-on-surface text-sm text-center lg:text-left">Branch Staffing Distribution</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($branchComparisons as $bc)
            <div class="flex items-center gap-4 p-4 border border-outline-variant/20 rounded-2xl hover:border-primary/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-black text-xl">
                    {{ $bc->total_staff }}
                </div>
                <div>
                    <p class="font-bold text-on-surface">{{ $bc->branch->name ?? 'HQ' }}</p>
                    <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-widest">Employees</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
