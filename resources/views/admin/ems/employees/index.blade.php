@extends('layouts.admin')
@section('title', 'Employee Directory')
@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">EMS · Human Resources</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Employee Directory</h1>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.ems.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-surface-container-high rounded-xl text-sm font-bold hover:bg-surface-variant transition-all">
            <span class="material-symbols-outlined text-[16px]">dashboard</span> EMS Dashboard
        </a>
        <a href="{{ route('admin.ems.employees.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-on-background text-white rounded-xl text-sm font-bold hover:bg-primary transition-all shadow-lg">
            <span class="material-symbols-outlined text-[18px]">person_add</span> Add Employee
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="bg-white border border-outline-variant/30 rounded-2xl p-4 mb-6 shadow-sm">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, ID, position..." class="border border-outline-variant rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
        <select name="branch_id" class="border border-outline-variant rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary/20">
            <option value="">All Branches</option>
            @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
            @endforeach
        </select>
        <select name="status" class="border border-outline-variant rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary/20">
            <option value="">All Status</option>
            @foreach(['active','inactive','suspended','terminated','on_leave'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <select name="employment_type" class="border border-outline-variant rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary/20">
            <option value="">All Types</option>
            @foreach(['full_time','part_time','contract','internship'] as $t)
            <option value="{{ $t }}" {{ request('employment_type') == $t ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$t)) }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-primary text-white rounded-xl py-2 text-sm font-bold hover:bg-primary/80 transition-all">Filter</button>
            <a href="{{ route('admin.ems.employees.index') }}" class="px-3 py-2 bg-surface-container-high rounded-xl text-sm hover:bg-surface-variant transition-all">✕</a>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-outline-variant/20 flex justify-between items-center">
        <p class="text-sm font-bold text-on-surface">{{ $employees->total() }} Employees Found</p>
        <p class="text-xs text-on-surface-variant">Page {{ $employees->currentPage() }} of {{ $employees->lastPage() }}</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="px-6 py-3 text-left text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Employee</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Position</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Branch</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Type</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Hired</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Status</th>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Salary</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($employees as $emp)
                <tr class="hover:bg-surface-container-low transition-colors">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $emp->photo_url }}" class="w-10 h-10 rounded-full object-cover border-2 border-outline-variant/20" alt="">
                            <div>
                                <p class="font-bold text-sm text-on-surface">{{ $emp->full_name }}</p>
                                <p class="text-[10px] text-primary font-bold">{{ $emp->employee_id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-sm text-on-surface">{{ $emp->position }}</p>
                        @if($emp->department)<p class="text-[10px] text-on-surface-variant">{{ $emp->department }}</p>@endif
                    </td>
                    <td class="px-4 py-3 text-sm text-on-surface">{{ $emp->branch?->name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[9px] font-black uppercase">{{ str_replace('_',' ',$emp->employment_type) }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm text-on-surface-variant">{{ $emp->date_hired->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase
                            {{ $emp->status === 'active' ? 'bg-emerald-100 text-emerald-700' :
                              ($emp->status === 'on_leave' ? 'bg-amber-100 text-amber-700' :
                              ($emp->status === 'suspended' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700')) }}">
                            {{ str_replace('_',' ',$emp->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm font-bold text-on-surface">{{ number_format($emp->basic_salary) }} TZS</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.ems.employees.show', $emp) }}" class="w-8 h-8 bg-blue-50 hover:bg-blue-500 hover:text-white text-blue-700 rounded-lg flex items-center justify-center transition-colors" title="View">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                            </a>
                            <a href="{{ route('admin.ems.employees.edit', $emp) }}" class="w-8 h-8 bg-amber-50 hover:bg-amber-500 hover:text-white text-amber-700 rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[14px]">edit</span>
                            </a>
                            <form action="{{ route('admin.ems.employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Remove {{ $emp->full_name }}?')">
                                @csrf @method('DELETE')
                                <button class="w-8 h-8 bg-red-50 hover:bg-red-500 hover:text-white text-red-700 rounded-lg flex items-center justify-center transition-colors" title="Delete">
                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-5xl block mb-3 opacity-20">group</span>
                        <p class="text-sm font-bold">No employees found</p>
                        <a href="{{ route('admin.ems.employees.create') }}" class="text-primary text-xs font-bold hover:underline mt-2 inline-block">Add your first employee →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($employees->hasPages())
    <div class="px-6 py-4 border-t border-outline-variant/20">
        {{ $employees->links() }}
    </div>
    @endif
</div>

@endsection
