@extends('layouts.admin')
@section('title', $employee->full_name)
@section('content')

{{-- Back + Actions --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.ems.employees.index') }}" class="w-9 h-9 flex items-center justify-center bg-surface-container-high rounded-xl hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        </a>
        <div>
            <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary">EMS · Employee Profile</p>
            <h1 class="font-headline-sm text-2xl text-on-surface">{{ $employee->full_name }}</h1>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.ems.employees.edit', $employee) }}" class="flex items-center gap-2 px-4 py-2.5 bg-on-background text-white rounded-xl text-sm font-bold hover:bg-primary transition-all">
            <span class="material-symbols-outlined text-[16px]">edit</span> Edit Profile
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: Employee Card --}}
    <div class="space-y-6">

        {{-- Profile Card --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
            <div class="bg-gradient-to-br from-on-background to-primary h-24 relative">
                <div class="absolute -bottom-8 left-6">
                    <img src="{{ $employee->photo_url }}" class="w-16 h-16 rounded-2xl object-cover border-4 border-white shadow-lg" alt="">
                </div>
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase
                        {{ $employee->status === 'active' ? 'bg-emerald-400/20 text-emerald-100 border border-emerald-400/30' :
                          ($employee->status === 'on_leave' ? 'bg-amber-400/20 text-amber-100 border border-amber-400/30' : 'bg-red-400/20 text-red-100 border border-red-400/30') }}">
                        {{ str_replace('_',' ',$employee->status) }}
                    </span>
                </div>
            </div>
            <div class="pt-12 px-6 pb-6">
                <h2 class="font-bold text-on-surface text-lg">{{ $employee->full_name }}</h2>
                <p class="text-sm text-on-surface-variant">{{ $employee->position }}</p>
                <p class="text-xs text-primary font-black mt-1">{{ $employee->employee_id }}</p>

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="bg-surface-container-low rounded-xl p-3 text-center">
                        <p class="font-black text-xl text-primary">{{ $attendanceRate }}%</p>
                        <p class="text-[9px] text-on-surface-variant uppercase font-bold">Attendance</p>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-3 text-center">
                        <p class="font-black text-xl text-primary">{{ $latestPerformance?->overall_score ?? '—' }}{{ $latestPerformance ? '%' : '' }}</p>
                        <p class="text-[9px] text-on-surface-variant uppercase font-bold">Performance</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-on-surface text-sm mb-4">Contact Information</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-3"><span class="material-symbols-outlined text-[18px] text-primary">phone</span><span>{{ $employee->phone }}</span></div>
                @if($employee->email)<div class="flex items-center gap-3"><span class="material-symbols-outlined text-[18px] text-primary">mail</span><span class="truncate">{{ $employee->email }}</span></div>@endif
                @if($employee->address)<div class="flex items-start gap-3"><span class="material-symbols-outlined text-[18px] text-primary mt-0.5">location_on</span><span>{{ $employee->address }}</span></div>@endif
                @if($employee->emergency_contact_name)
                <div class="pt-3 border-t border-outline-variant/20">
                    <p class="text-[10px] font-black uppercase text-on-surface-variant mb-2">Emergency Contact</p>
                    <p class="font-bold">{{ $employee->emergency_contact_name }}</p>
                    <p class="text-on-surface-variant">{{ $employee->emergency_contact_phone }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Employment Card --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-on-surface text-sm mb-4">Employment Details</h3>
            <div class="space-y-3 text-sm">
                @foreach([
                    ['label'=>'Branch','value'=>$employee->branch?->name ?? 'HQ / Unassigned'],
                    ['label'=>'Department','value'=>$employee->department ?? '—'],
                    ['label'=>'Type','value'=>ucwords(str_replace('_',' ',$employee->employment_type))],
                    ['label'=>'Date Hired','value'=>$employee->date_hired->format('M d, Y')],
                    ['label'=>'Basic Salary','value'=>number_format($employee->basic_salary).' TZS'],
                    ['label'=>'Payment','value'=>ucwords(str_replace('_',' ',$employee->payment_method))],
                    ['label'=>'Shift','value'=>$employee->current_shift ? $employee->current_shift->name . ' ('.\Carbon\Carbon::parse($employee->current_shift->start_time)->format('h:i A').' - '.\Carbon\Carbon::parse($employee->current_shift->end_time)->format('h:i A').')' : 'No Active Shift'],
                ] as $row)
                <div class="flex justify-between">
                    <span class="text-on-surface-variant font-bold text-[10px] uppercase">{{ $row['label'] }}</span>
                    <span class="font-bold text-on-surface text-right max-w-[160px]">{{ $row['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right: Tabs Content --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Attendance This Month --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-outline-variant/20">
                <h3 class="font-bold text-on-surface text-sm">Attendance — {{ now()->format('F Y') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-surface-container-low">
                        <tr>
                            <th class="px-4 py-2 text-left text-[10px] font-black uppercase text-on-surface-variant">Date</th>
                            <th class="px-4 py-2 text-left text-[10px] font-black uppercase text-on-surface-variant">Check In</th>
                            <th class="px-4 py-2 text-left text-[10px] font-black uppercase text-on-surface-variant">Check Out</th>
                            <th class="px-4 py-2 text-left text-[10px] font-black uppercase text-on-surface-variant">Hours</th>
                            <th class="px-4 py-2 text-left text-[10px] font-black uppercase text-on-surface-variant">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($employee->attendances->sortByDesc('date') as $att)
                        <tr class="hover:bg-surface-container-low">
                            <td class="px-4 py-2.5">{{ $att->date->format('M d, Y') }}</td>
                            <td class="px-4 py-2.5">{{ $att->check_in ?? '—' }}</td>
                            <td class="px-4 py-2.5">{{ $att->check_out ?? '—' }}</td>
                            <td class="px-4 py-2.5">{{ $att->total_hours ?? '—' }}h</td>
                            <td class="px-4 py-2.5">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase
                                    {{ $att->status==='present'?'bg-emerald-100 text-emerald-700':
                                      ($att->status==='absent'?'bg-red-100 text-red-700':'bg-amber-100 text-amber-700') }}">
                                    {{ $att->status }}{{ $att->is_late ? ' (Late)' : '' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-on-surface-variant text-xs">No attendance records this month.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Leave Requests --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-outline-variant/20">
                <h3 class="font-bold text-on-surface text-sm">Leave Requests</h3>
            </div>
            <div class="divide-y divide-outline-variant/10">
                @forelse($employee->leaveRequests as $leave)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-sm text-on-surface capitalize">{{ str_replace('_',' ',$leave->leave_type) }} Leave</p>
                        <p class="text-xs text-on-surface-variant">{{ $leave->start_date->format('M d') }} – {{ $leave->end_date->format('M d, Y') }} · {{ $leave->total_days }} days</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase
                        {{ $leave->status==='approved'?'bg-emerald-100 text-emerald-700':
                          ($leave->status==='rejected'?'bg-red-100 text-red-700':'bg-amber-100 text-amber-700') }}">
                        {{ $leave->status }}
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-on-surface-variant text-xs">No leave requests.</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Payroll --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-outline-variant/20">
                <h3 class="font-bold text-on-surface text-sm">Payroll History</h3>
            </div>
            <div class="divide-y divide-outline-variant/10">
                @forelse($employee->payrollRecords as $pr)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-sm text-on-surface">{{ \Carbon\Carbon::createFromDate($pr->year, $pr->month, 1)->format('F Y') }}</p>
                        <p class="text-xs text-on-surface-variant">Basic: {{ number_format($pr->basic_salary) }} + Bonus: {{ number_format($pr->bonuses) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-primary">{{ number_format($pr->net_salary) }} TZS</p>
                        <span class="text-[9px] font-black uppercase {{ $pr->status==='paid'?'text-emerald-600':'text-amber-600' }}">{{ $pr->status }}</span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-on-surface-variant text-xs">No payroll records.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
