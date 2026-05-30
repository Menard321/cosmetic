@extends('layouts.admin')
@section('title', 'Attendance Management')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">EMS · HR</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Attendance Management</h1>
    </div>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([['label'=>'Present','value'=>$todayStats['present'],'color'=>'emerald','icon'=>'check_circle'],['label'=>'Absent','value'=>$todayStats['absent'],'color'=>'red','icon'=>'cancel'],['label'=>'Late','value'=>$todayStats['late'],'color'=>'amber','icon'=>'schedule'],['label'=>'On Leave','value'=>$todayStats['on_leave'],'color'=>'blue','icon'=>'beach_access']] as $s)
    <div class="bg-white border border-{{ $s['color'] }}-200 rounded-2xl p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-700 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">{{ $s['icon'] }}</span>
        </div>
        <div><p class="text-xl font-black text-on-surface">{{ $s['value'] }}</p><p class="text-[10px] text-on-surface-variant font-bold uppercase">{{ $s['label'] }}</p></div>
    </div>
    @endforeach
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-white border border-outline-variant/30 rounded-2xl p-4 shadow-sm">
        <form method="GET" class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <input type="date" name="date" value="{{ $date->format('Y-m-d') }}" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            <select name="branch_id" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
                <option value="">All Branches</option>
                @foreach($branches as $b)<option value="{{ $b->id }}" {{ request('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
            </select>
            <select name="status" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
                <option value="">All Status</option>
                @foreach(['present','absent','half_day','on_leave'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>@endforeach
            </select>
            <button type="submit" class="bg-primary text-white rounded-xl py-2 text-sm font-bold">Filter</button>
        </form>
    </div>
    <div class="bg-white border border-outline-variant/30 rounded-2xl p-4 shadow-sm">
        <p class="font-bold text-sm text-on-surface mb-3">Quick Mark</p>
        <form action="{{ route('admin.ems.attendance.store') }}" method="POST" class="space-y-2">
            @csrf
            <select name="employee_id" required class="w-full border border-outline-variant rounded-xl px-3 py-2 text-sm">
                <option value="">Select Employee</option>
                @foreach(\App\Models\Employee::where('status','active')->orderBy('full_name')->get() as $emp)
                <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                @endforeach
            </select>
            <input type="date" name="date" value="{{ today()->format('Y-m-d') }}" required class="w-full border border-outline-variant rounded-xl px-3 py-2 text-sm">
            <div class="grid grid-cols-2 gap-2">
                <input type="time" name="check_in" value="08:00" class="border border-outline-variant rounded-xl px-2 py-2 text-sm">
                <input type="time" name="check_out" class="border border-outline-variant rounded-xl px-2 py-2 text-sm">
            </div>
            <select name="status" required class="w-full border border-outline-variant rounded-xl px-3 py-2 text-sm">
                @foreach(['present','absent','half_day','on_leave'] as $s)<option value="{{ $s }}">{{ ucwords(str_replace('_',' ',$s)) }}</option>@endforeach
            </select>
            <input type="hidden" name="method" value="manual">
            <button type="submit" class="w-full py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-on-background transition-all">Mark Attendance</button>
        </form>
    </div>
</div>
<div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-outline-variant/20"><h3 class="font-bold text-sm text-on-surface">Records — {{ $date->format('l, F d, Y') }}</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="px-6 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Employee</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Branch</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">In</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Out</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Hours</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($records as $att)
                <tr class="hover:bg-surface-container-low">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $att->employee->photo_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                            <div><p class="font-bold text-on-surface">{{ $att->employee->full_name }}</p><p class="text-[10px] text-primary">{{ $att->employee->employee_id }}</p></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-on-surface-variant">{{ $att->employee->branch?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $att->check_in ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $att->check_out ?? '—' }}</td>
                    <td class="px-4 py-3 font-bold">{{ $att->total_hours ? $att->total_hours.'h' : '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase {{ $att->status==='present'?'bg-emerald-100 text-emerald-700':($att->status==='absent'?'bg-red-100 text-red-700':'bg-amber-100 text-amber-700') }}">
                            {{ $att->status }}{{ $att->is_late?' · Late':'' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-on-surface-variant text-sm">No records for this date.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($records->hasPages())<div class="px-6 py-4 border-t border-outline-variant/20">{{ $records->links() }}</div>@endif
</div>
@endsection
