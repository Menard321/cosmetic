@extends('layouts.admin')
@section('title', 'Payroll Management')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">EMS · Finance</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Payroll Management</h1>
    </div>
    <form action="{{ route('admin.ems.payroll.generate') }}" method="POST" class="flex items-center gap-3">
        @csrf
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all">
            <span class="material-symbols-outlined text-[18px]">auto_fix_high</span> Generate Payroll
        </button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-emerald-200 rounded-2xl p-4 shadow-sm">
        <p class="text-xl font-black text-emerald-600">TZS {{ number_format($stats['total_payroll']) }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Total Payroll</p>
    </div>
    <div class="bg-white border border-blue-200 rounded-2xl p-4 shadow-sm">
        <p class="text-2xl font-black text-blue-600">{{ $stats['total_employees'] }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Active Employees</p>
    </div>
    <div class="bg-white border border-emerald-200 rounded-2xl p-4 shadow-sm">
        <p class="text-2xl font-black text-emerald-600">{{ $stats['paid_count'] }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Paid</p>
    </div>
    <div class="bg-white border border-amber-200 rounded-2xl p-4 shadow-sm">
        <p class="text-2xl font-black text-amber-600">{{ $stats['pending_count'] }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Pending</p>
    </div>
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl p-4 mb-6 shadow-sm">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <select name="month" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            @for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $month==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>@endfor
        </select>
        <input type="number" name="year" value="{{ $year }}" min="2020" max="2030" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
        <select name="branch_id" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            <option value="">All Branches</option>
            @foreach($branches as $b)<option value="{{ $b->id }}" {{ request('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
        </select>
        <button type="submit" class="bg-primary text-white rounded-xl py-2 text-sm font-bold">Filter</button>
    </form>
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-outline-variant/20 flex justify-between items-center">
        <h3 class="font-bold text-sm text-on-surface">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }} Payroll</h3>
        <p class="text-xs text-on-surface-variant">{{ $records->total() }} records</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="px-6 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Employee</th>
                    <th class="px-4 py-3 text-right text-[10px] font-black uppercase text-on-surface-variant">Basic</th>
                    <th class="px-4 py-3 text-right text-[10px] font-black uppercase text-on-surface-variant">Allowances</th>
                    <th class="px-4 py-3 text-right text-[10px] font-black uppercase text-on-surface-variant">Bonuses</th>
                    <th class="px-4 py-3 text-right text-[10px] font-black uppercase text-on-surface-variant">Deductions</th>
                    <th class="px-4 py-3 text-right text-[10px] font-black uppercase text-on-surface-variant">Net Salary</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Status</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($records as $pr)
                <tr class="hover:bg-surface-container-low">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $pr->employee->photo_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                            <div>
                                <p class="font-bold text-on-surface">{{ $pr->employee->full_name }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ $pr->employee->position }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right text-on-surface-variant">{{ number_format($pr->basic_salary) }}</td>
                    <td class="px-4 py-3 text-right text-emerald-600">+{{ number_format($pr->allowances) }}</td>
                    <td class="px-4 py-3 text-right text-emerald-600">+{{ number_format($pr->bonuses) }}</td>
                    <td class="px-4 py-3 text-right text-red-600">-{{ number_format($pr->deductions) }}</td>
                    <td class="px-4 py-3 text-right font-black text-primary">{{ number_format($pr->net_salary) }} TZS</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase {{ $pr->status==='paid'?'bg-emerald-100 text-emerald-700':($pr->status==='processed'?'bg-blue-100 text-blue-700':'bg-amber-100 text-amber-700') }}">
                            {{ $pr->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($pr->status !== 'paid')
                        <form action="{{ route('admin.ems.payroll.mark-paid', $pr) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="px-3 py-1 bg-emerald-100 hover:bg-emerald-500 hover:text-white text-emerald-700 rounded-lg text-[10px] font-black uppercase transition-colors">Mark Paid</button>
                        </form>
                        @else
                        <span class="text-xs text-emerald-600 font-bold">✓ Paid {{ $pr->paid_at?->format('M d') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">No payroll records. Click "Generate Payroll" to create them.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($records->hasPages())<div class="px-6 py-4 border-t border-outline-variant/20">{{ $records->links() }}</div>@endif
</div>
@endsection
